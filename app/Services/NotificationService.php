<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;

class NotificationService
{
    // ──────────────────────────────────────────────────────────────────────────
    //  Inventory Events
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Notify all admins that a product's stock is running low (< 50 units).
     */
    public static function lowStock(Product $product): void
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        self::createForUsers(
            $admins,
            'inventory_low',
            'Low Stock Alert',
            "\"{$product->name}\" is running low - only {$product->stock} unit(s) remaining.",
            [
                'action_url'   => route('admin.products.edit', $product),
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'stock'        => $product->stock,
            ]
        );
    }

    /**
     * Notify all admins that a product is out of stock.
     */
    public static function outOfStock(Product $product): void
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        self::createForUsers(
            $admins,
            'inventory_out',
            'Out of Stock',
            "\"{$product->name}\" is now completely out of stock.",
            [
                'action_url'   => route('admin.products.edit', $product),
                'product_id'   => $product->id,
                'product_name' => $product->name,
            ]
        );
    }

    // ──────────────────────────────────────────────────────────────────────────
    //  Sales Events
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Notify all admins that a reseller recorded a new B2C sale.
     */
    public static function newSale(Sale $sale, User $reseller): void
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        $productName = optional($sale->product)->name ?? 'a product';
        $amount      = number_format($sale->total_price, 2);

        self::createForUsers(
            $admins,
            'new_sale',
            'New Sale Recorded',
            "{$reseller->name} sold {$sale->quantity}x {$productName} for RM {$amount}.",
            [
                'action_url'  => route('admin.sales.index'),
                'sale_id'     => $sale->id,
                'reseller_id' => $reseller->id,
            ]
        );
    }

    // ──────────────────────────────────────────────────────────────────────────
    //  Order / Wholesale Events
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Notify all admins that a reseller placed a new wholesale order.
     */
    public static function newOrder(Order $order, User $reseller): void
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        $amount = number_format($order->total_price, 2);

        self::createForUsers(
            $admins,
            'new_order',
            'New Wholesale Order',
            "{$reseller->name} placed a wholesale order worth RM {$amount}.",
            [
                'action_url'  => route('admin.orders.show', $order),
                'order_id'    => $order->id,
                'reseller_id' => $reseller->id,
            ]
        );
    }

    /**
     * Notify the reseller that their order was approved / payment confirmed.
     */
    public static function orderApproved(Order $order): void
    {
        $reseller = User::find($order->user_id);
        if (! $reseller) return;

        $amount = number_format($order->total_price, 2);

        self::createForUsers(
            collect([$reseller]),
            'order_approved',
            'Order Approved',
            "Your order #ORD-{$order->id} (RM {$amount}) has been confirmed and stock has been updated.",
            [
                'action_url' => route('reseller.orders.show', $order),
                'order_id'   => $order->id,
            ]
        );
    }

    // ──────────────────────────────────────────────────────────────────────────
    //  User / Registration Events
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Notify all admins that a new reseller account has been registered.
     */
    public static function newReseller(User $reseller): void
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        self::createForUsers(
            $admins,
            'new_reseller',
            'New Reseller Registered',
            "{$reseller->name} ({$reseller->email}) has joined as a reseller.",
            [
                'action_url'  => route('admin.resellers.index'),
                'reseller_id' => $reseller->id,
            ]
        );
    }

    // ──────────────────────────────────────────────────────────────────────────
    //  Internal Helper
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Bulk-create notifications for a collection of users.
     */
    private static function createForUsers(
        iterable $users,
        string $type,
        string $title,
        string $message,
        array $data = []
    ): void {
        $now = now();

        $rows = collect($users)->map(function ($user) use ($type, $title, $message, $data, $now) {
            return [
                'user_id'    => $user->id,
                'type'       => $type,
                'title'      => $title,
                'message'    => $message,
                'is_read'    => false,
                'data'       => json_encode($data),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })->all();

        if (! empty($rows)) {
            Notification::insert($rows);
        }
    }
}
