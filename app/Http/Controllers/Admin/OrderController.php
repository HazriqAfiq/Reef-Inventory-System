<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')->latest()->paginate(15)->appends($request->all());
        
        if ($request->ajax() && !$request->header('X-SPA')) {
            return view('admin.orders.partials.table', compact('orders'))->render();
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'shippingAddress');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order, \App\Services\EasyParcelService $easyParcel)
    {
        $request->validate([
            'status'          => 'required|string|in:pending,paid,processing,shipped,delivered,cancelled',
            'courier_name'    => 'nullable|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $oldStatus = $order->status;
        
        $updateData = [
            'status'          => $request->status,
            'courier_name'    => $request->courier_name,
            'tracking_number' => $request->tracking_number,
        ];

        // Manage status-specific timestamps for timeline precision
        if ($request->status === Order::STATUS_SHIPPED) {
            // AUTOMATED BOOKING: If status is shipped and NO tracking number is supplied, book via EasyParcel!
            if (!$request->tracking_number && config('services.easyparcel.key')) {
                if ($request->courier_name) {
                    $order->courier_name = $request->courier_name;
                }
                
                $shipment = $easyParcel->createShipment($order);
                
                if ($shipment) {
                    $updateData['courier_name']    = $shipment['courier_name'];
                    $updateData['tracking_number'] = $shipment['tracking_number'];
                    $updateData['shipped_at']      = now();
                } else {
                    return back()->with('error', 'Failed to generate automatic shipment booking via EasyParcel. Please enter manually or check your keys.');
                }
            } else {
                if (!$order->shipped_at) {
                    $updateData['shipped_at'] = now();
                }
            }
        } elseif ($request->status === Order::STATUS_DELIVERED) {
            if (!$order->shipped_at) {
                $updateData['shipped_at'] = now();
            }
            if (!$order->delivered_at) {
                $updateData['delivered_at'] = now();
            }
        } else {
            // Rolling back status resets progress timestamps
            if ($request->status === 'pending' || $request->status === 'paid' || $request->status === 'processing') {
                $updateData['shipped_at'] = null;
                $updateData['delivered_at'] = null;
            }
        }

        $order->update($updateData);

        \App\Models\ActivityLog::log(
            'order_status_updated',
            $order,
            "Updated order status from {$oldStatus} to {$request->status}",
            [
                'old_status'      => $oldStatus, 
                'new_status'      => $request->status,
                'courier_name'    => $updateData['courier_name'],
                'tracking_number' => $updateData['tracking_number']
            ]
        );

        return back()->with('success', 'Order status and fulfillment details updated successfully.');
    }

    public function export()
    {
        $orders = Order::with('user')->latest()->get();
        $filename = "orders_" . now()->format('Y-m-d_His') . ".csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Headers
        fputcsv($handle, ['Order ID', 'Customer', 'Email', 'Total Price', 'Status', 'Date']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->user ? $order->user->name : 'Guest',
                $order->user ? $order->user->email : 'N/A',
                $order->total_price,
                strtoupper($order->status),
                $order->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
        exit;
    }
}
