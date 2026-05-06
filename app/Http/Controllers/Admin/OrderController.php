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

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        \App\Models\ActivityLog::log(
            'order_status_updated',
            $order,
            "Updated order status from {$oldStatus} to {$request->status}",
            ['old_status' => $oldStatus, 'new_status' => $request->status]
        );

        return back()->with('success', 'Order status updated successfully.');
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
