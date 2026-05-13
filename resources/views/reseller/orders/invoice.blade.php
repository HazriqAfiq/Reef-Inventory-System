<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt ORD_{{ $order->id }}</title>
    <style>
        @page {
            margin: 40px;
        }
        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            color: #0f172a;
            margin: 0;
            padding: 0;
            font-size: 11px;
            line-height: 1.5;
        }
        .container {
            width: 100%;
        }
        /* Double line divider for luxury framing */
        .double-divider {
            border-top: 1px solid #0f172a;
            border-bottom: 3px double #0f172a;
            height: 3px;
            margin: 15px 0 25px 0;
        }
        /* Brand Header Layout */
        .brand-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .brand-logo {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #0f172a;
            line-height: 1;
        }
        .brand-tagline {
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #475569;
            margin-top: 4px;
        }
        .document-title {
            text-align: right;
            font-size: 18px;
            font-weight: 850;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #0f172a;
            vertical-align: bottom;
        }
        .company-details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            color: #475569;
            margin-bottom: 20px;
        }
        .company-details-left {
            text-align: left;
            line-height: 1.4;
        }
        .company-details-right {
            text-align: right;
            line-height: 1.4;
        }
        /* Metadata Split Table */
        .metadata-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .meta-col-left {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        .meta-col-right {
            width: 50%;
            vertical-align: top;
            padding-left: 20px;
            border-left: 1px solid #e2e8f0;
        }
        .section-label {
            font-size: 8px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        .billed-to-name {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 4px 0;
        }
        .billed-to-meta {
            font-size: 9px;
            color: #334155;
            line-height: 1.4;
        }
        /* Right Side Metadata Key-Values */
        .meta-kv-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-kv-table td {
            padding: 3.5px 0;
            font-size: 9px;
            color: #334155;
        }
        .meta-kv-label {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
        }
        .meta-kv-value {
            text-align: right;
            font-weight: bold;
            color: #0f172a;
        }
        .meta-kv-value-mono {
            text-align: right;
            font-family: monospace;
            font-size: 10px;
            color: #0f172a;
        }
        /* Ledger Items Table */
        .ledger-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .ledger-table th {
            background-color: #f8fafc;
            border-top: 1px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            padding: 10px 12px;
            font-size: 8px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #0f172a;
            text-align: left;
        }
        .ledger-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 10px;
            vertical-align: middle;
        }
        .item-title {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
        }
        .item-subtext {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2.5px;
        }
        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .tabular-nums {
            font-family: 'Times New Roman', Times, Georgia, serif;
            font-size: 10.5px;
        }
        /* Grand Summary Blocks */
        .summary-container-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .stamp-cell {
            width: 55%;
            vertical-align: top;
            position: relative;
        }
        .financial-cell {
            width: 45%;
            vertical-align: top;
        }
        /* Secure verified badge look */
        .verified-stamp {
            border: 2px dashed #15803d;
            color: #15803d;
            background: rgba(21, 128, 61, 0.03);
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 8px 15px;
            display: inline-block;
            border-radius: 4px;
            margin-top: 10px;
            line-height: 1.3;
            transform: rotate(-3deg);
        }
        .stamp-title {
            font-size: 11px;
            font-weight: 900;
            display: block;
            margin-bottom: 1px;
        }
        .stamp-meta {
            font-size: 7.5px;
            color: #166534;
            letter-spacing: 0.5px;
        }
        /* Financial Totals */
        .financial-totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .financial-totals-table td {
            padding: 5px 0;
            font-size: 10px;
            color: #475569;
        }
        .total-row-highlight td {
            border-top: 1.5px solid #0f172a;
            border-bottom: 2px double #0f172a;
            padding: 8px 0;
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
        }
        /* Premium Executive Footer */
        .receipt-footer {
            margin-top: 60px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Brand and Document Title Section -->
        <table class="brand-table">
            <tr>
                <td style="text-align: left; vertical-align: top;">
                    <div class="brand-logo">Reef Store</div>
                    <div class="brand-tagline">Signature Fragrance & Olfactory Artistry</div>
                </td>
                <td class="document-title">
                    Official Receipt
                </td>
            </tr>
        </table>

        <!-- Luxury Framing Divider -->
        <div class="double-divider"></div>

        <!-- Corporate Address Block -->
        <table class="company-details-table">
            <tr>
                <td class="company-details-left">
                    <strong>Reef Store Executive Office</strong><br>
                    Suite 12-A, Signature Tower, Olfactory Park<br>
                    Kuala Lumpur, 50450 Wilayah Persekutuan<br>
                    Contact: partner@reefperfume.com &bull; +60 (3) 9000 8888
                </td>
                <td class="company-details-right">
                    <strong>Secure Digital Registry</strong><br>
                    System Ledger: Reef IMS B2B Gateway<br>
                    Origin: Malaysia HQ Core Inventory<br>
                    Access Clearance: VERIFIED BUSINESS RELATION
                </td>
            </tr>
        </table>

        <!-- Metadata Section (Billed to vs Document Metadata) -->
        <table class="metadata-table">
            <tr>
                <td class="meta-col-left">
                    <div class="section-label">Billed Recipient</div>
                    <h3 class="billed-to-name">{{ $order->user->name }}</h3>
                    <div class="billed-to-meta">
                        <strong>Role Registry:</strong> Authorized Reseller Partner<br>
                        <strong>Registered Email:</strong> {{ $order->user->email }}<br>
                        @if($order->shippingAddress)
                            <strong>Delivery Address:</strong><br>
                            {{ $order->shippingAddress->address }}<br>
                            {{ $order->shippingAddress->postcode }} {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}
                        @else
                            <strong>Delivery Address:</strong> Not Specified (HQ Pick-up)
                        @endif
                    </div>
                </td>
                <td class="meta-col-right">
                    <div class="section-label">Transaction Registry</div>
                    <table class="meta-kv-table">
                        <tr>
                            <td class="meta-kv-label">Receipt Identifier</td>
                            <td class="meta-kv-value">REC-ORD_{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="meta-kv-label">Payment Date</td>
                            <td class="meta-kv-value">{{ $order->updated_at->format('d M Y - H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="meta-kv-label">Gateway Reference</td>
                            <td class="meta-kv-value-mono">{{ $order->billplz_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="meta-kv-label">Registry Clearance</td>
                            <td class="meta-kv-value" style="color: #15803d;">PAID & CLOSED</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Ledger Table of Items -->
        <table class="ledger-table">
            <thead>
                <tr>
                    <th style="width: 55%;">Product Inventory Profile</th>
                    <th style="width: 15%; text-align: center;">Wholesale Rate</th>
                    <th style="width: 15%; text-align: center;">Item Qty</th>
                    <th style="width: 15%; text-align: right;">Line Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <p class="item-title">{{ $item->product->name }}</p>
                            <div class="item-subtext">SKU: {{ $item->product->sku }} &middot; Volume: {{ $item->product->volume_ml }}ml</div>
                        </td>
                        <td class="text-center tabular-nums">RM {{ number_format($item->price, 2) }}</td>
                        <td class="text-center tabular-nums font-black">{{ $item->quantity }}</td>
                        <td class="text-right tabular-nums font-black">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Verification Stamp & Totals Split -->
        <table class="summary-container-table">
            <tr>
                <!-- Secure Stamp Seal -->
                <td class="stamp-cell">
                    <div class="verified-stamp">
                        <span class="stamp-title">Securely Settled</span>
                        <span class="stamp-meta">Reef Store B2B Registry &bull; ID: #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </td>
                
                <!-- Financial Summary -->
                <td class="financial-cell">
                    <table class="financial-totals-table">
                        <tr>
                            <td>Gross Subtotal</td>
                            <td class="text-right tabular-nums">RM {{ number_format($order->total_price, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Sourcing Fee / GST (0%)</td>
                            <td class="text-right tabular-nums">RM 0.00</td>
                        </tr>
                        <tr class="total-row-highlight">
                            <td>TOTAL PAID</td>
                            <td class="text-right tabular-nums">RM {{ number_format($order->total_price, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Executive Footer -->
        <div class="receipt-footer">
            Automated official documentation &middot; Reef Store &copy; {{ now()->year }} &middot; Confidential Sourcing Asset
        </div>

    </div>

</body>
</html>
