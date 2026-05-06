<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice ORD_{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 0; }
        .container { padding: 40px; }
        .header { display: flex; text-align: right; width: 100%; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .header table { width: 100%; }
        .title { font-size: 28px; font-weight: bold; color: #002244; margin: 0; padding: 0; }
        .company-info { font-size: 12px; color: #777; margin-top: 5px; }
        .invoice-details { margin-top: 20px; }
        .invoice-details table { width: 100%; }
        .invoice-details td { vertical-align: top; }
        .to-info { width: 50%; }
        .to-info h3 { margin: 0 0 5px 0; font-size: 14px; color: #555; text-transform: uppercase; }
        .to-info p { margin: 0 0 3px 0; font-weight: bold; }
        .meta-info { width: 50%; text-align: right; }
        .meta-info table { width: 100%; border-collapse: collapse; }
        .meta-info td { padding: 3px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 40px; }
        .items-table th { background-color: #f8f9fa; color: #444; font-weight: bold; padding: 12px; text-align: left; border-bottom: 2px solid #ddd; text-transform: uppercase; font-size: 12px;}
        .items-table td { padding: 12px; border-bottom: 1px solid #eee; }
        .items-table th.right, .items-table td.right { text-align: right; }
        .items-table th.center, .items-table td.center { text-align: center; }
        .total-row td { background-color: #f8f9fa; font-weight: bold; font-size: 16px; border-top: 2px solid #333; border-bottom: 2px solid #333;}
        .footer { margin-top: 50px; text-align: center; font-size: 11px; color: #888; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td style="text-align: left;">
                        <h1 class="title">INVOICE</h1>
                    </td>
                    <td style="text-align: right;">
                        <h2 style="margin: 0; color: #002244;">Reef Malaysia</h2>
                        <div class="company-info">
                            123 Fragrance Valley, Tower A<br>
                            Kuala Lumpur, 50000 MY<br>
                            hq@reefperfume.com
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="invoice-details">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="to-info">
                        <h3>Billed To:</h3>
                        <p>{{ $order->user->name }}</p>
                        <span style="color: #666; font-size: 12px;">Role: {{ ucfirst($order->user->role) }}<br>{{ $order->user->email }}</span>
                    </td>
                    <td class="meta-info">
                        <table align="right" style="width: auto;">
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #777;">Invoice #</td>
                                <td style="font-weight: bold; text-align: right;">ORD_{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #777;">Date</td>
                                <td style="font-weight: bold; text-align: right;">{{ $order->updated_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #777;">Status</td>
                                <td style="font-weight: bold; text-align: right; color: green;">PAID</td>
                            </tr>
                            <tr>
                                <td style="text-align: right; padding-right: 15px; color: #777;">Billplz Ref</td>
                                <td style="font-weight: bold; text-align: right;">{{ $order->billplz_id }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="center">Quantity</th>
                    <th class="right">Unit Price</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->name }}</strong><br>
                            <span style="font-size: 11px; color: #888;">{{ $item->product->sku }} &bull; {{ $item->product->volume_ml }}ml</span>
                        </td>
                        <td class="center">{{ $item->quantity }}</td>
                        <td class="right">RM {{ number_format($item->price, 2) }}</td>
                        <td class="right">RM {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
                <tr><td colspan="4" style="border: none; padding: 5px;">&nbsp;</td></tr>
                <tr class="total-row">
                    <td colspan="3" class="right" style="padding: 15px 12px; letter-spacing: 1px;">TOTAL PAID</td>
                    <td class="right" style="padding: 15px 12px; color: #002244;">RM {{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            Generated automatically by Reef Perfume Inventory Management System.<br>
            Thank you for restocking with us.
        </div>
    </div>
</body>
</html>
