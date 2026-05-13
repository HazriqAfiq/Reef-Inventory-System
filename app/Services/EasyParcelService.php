<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EasyParcelService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.easyparcel.key');
        // fallback to standard demo endpoint if not specified
        $this->apiUrl = rtrim(config('services.easyparcel.url', 'https://demo.easyparcel.com/v1'), '/');
    }

    /**
     * Map common local courier names to standard EasyParcel slugs.
     */
    protected function getEasyParcelCourierSlug(?string $courier): string
    {
        if (!$courier) {
            return 'auto';
        }
        $name = strtolower(trim($courier));

        return match(true) {
            str_contains($name, 'poslaju') || str_contains($name, 'pos laju') => 'poslaju',
            str_contains($name, 'j&t') || str_contains($name, 'jt') => 'jtexpress',
            str_contains($name, 'dhl') => 'dhlecommerce',
            str_contains($name, 'fedex') => 'fedex',
            str_contains($name, 'ninja') => 'ninjavan',
            str_contains($name, 'gdex') => 'gdex',
            default => 'auto',
        };
    }

    /**
     * Automatically book a consignment shipment via EasyParcel API
     */
    public function createShipment(Order $order): array|bool
    {
        // Check for required environment settings first
        if (!$this->apiKey) {
            Log::warning("EasyParcel API integration key is missing inside environment settings.");
            return false;
        }

        $address = $order->loadMissing('shippingAddress', 'items')->shippingAddress;
        if (!$address) {
            Log::warning("EasyParcel order booking failed: order has no shipping address.");
            return false;
        }

        // Calculate weight (default to 0.5kg, or 0.2kg per wholesale item)
        $weight = max(0.5, $order->items->sum('quantity') * 0.2); 

        $courierSlug = $this->getEasyParcelCourierSlug($order->courier_name);

        $payload = [
            'api'    => $this->apiKey,
            'action' => 'ECBookShipment',
            'bulk'   => [
                [
                    // Sender details (Your wholesale warehouse)
                    'send_name'     => config('services.easyparcel.sender_name', 'Reef Store Warehouse'),
                    'send_phone'    => config('services.easyparcel.sender_phone', '0123456789'),
                    'send_email'    => 'warehouse@reefstore.com',
                    'send_addr1'    => config('services.easyparcel.sender_address', 'No 1, Jalan Perindustrian 2'),
                    'send_city'     => config('services.easyparcel.sender_city', 'Shah Alam'),
                    'send_state'    => config('services.easyparcel.sender_state', 'Selangor'),
                    'send_postcode' => config('services.easyparcel.sender_postcode', '40000'),
                    'send_country'  => 'MY',

                    // Recipient details (Wholesale Reseller / Consignee)
                    'rec_name'     => $address->first_name . ' ' . $address->last_name,
                    'rec_phone'    => $address->phone,
                    'rec_email'    => $address->email ?? $order->user->email,
                    'rec_addr1'    => $address->address,
                    'rec_city'     => $address->city,
                    'rec_state'    => $address->state,
                    'rec_postcode' => $address->postcode,
                    'rec_country'  => 'MY',

                    // Parcel Specs
                    'weight'       => $weight,
                    'content'      => 'Wholesale Cosmetics / Fragrances',
                    'value'        => $order->total_price,
                    'courier'      => $courierSlug,
                ]
            ]
        ];

        try {
            $response = Http::asForm()->post("{$this->apiUrl}/", $payload);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['code']) && $result['code'] == 0 && !empty($result['result'])) {
                    $shipment = $result['result'][0];

                    if (isset($shipment['status']) && $shipment['status'] === 'success') {
                        return [
                            'courier_name'    => $shipment['courier'] ?? $order->courier_name ?? 'EasyParcel Partner',
                            'tracking_number' => $shipment['tracking_no'] ?? '',
                            'awb_url'         => $shipment['awb'] ?? null,
                        ];
                    }
                    Log::error("EasyParcel shipment booking inner failure: " . json_encode($shipment));
                } else {
                    Log::error("EasyParcel API returned error response: " . json_encode($result));
                }
            } else {
                Log::error("EasyParcel network connection failure: Status Code " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Failed to execute EasyParcel API connection: " . $e->getMessage());
        }

        return false;
    }
}
