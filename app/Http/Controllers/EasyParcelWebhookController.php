<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EasyParcelWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from EasyParcel.
     */
    public function handleStatusUpdate(Request $request)
    {
        Log::info("EasyParcel Webhook callback received: " . json_encode($request->all()));

        $trackingNumber = $request->input('tracking_no');
        
        // EasyParcel statuses can include "successfully delivered", "delivered", or state description text
        $statusDescription = strtolower($request->input('status_description', '')); 

        if (!$trackingNumber) {
            return response()->json(['error' => 'Missing tracking number'], 400);
        }

        $order = Order::where('tracking_number', $trackingNumber)->first();

        if ($order) {
            // Check if status reports delivery successfully
            if (str_contains($statusDescription, 'delivered') && $order->status !== Order::STATUS_DELIVERED) {
                $order->update([
                    'status'       => Order::STATUS_DELIVERED,
                    'delivered_at' => now(),
                ]);

                \App\Models\ActivityLog::log(
                    'order_delivered_automatically',
                    $order,
                    "Order shipment was marked as delivered automatically via EasyParcel Webhook tracker.",
                    ['tracking_number' => $trackingNumber]
                );

                Log::info("Order #{$order->id} was automatically marked as DELIVERED via EasyParcel webhook.");
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'No matching order found for tracking number'], 404);
    }
}
