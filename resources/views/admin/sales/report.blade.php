<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report - {{ $periodLabel }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #1e3a8a;
            margin: 0 0 5px 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            color: #64748b;
            margin: 0;
            font-size: 14px;
        }
        .kpi-container {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .kpi-container td {
            text-align: center;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            width: 33.33%;
        }
        .kpi-title {
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            font-size: 10px;
            display: block;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #e2e8f0;
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #fbfcff;
        }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .section-title {
            color: #1e3a8a;
            font-size: 14px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }
        .highlight-row {
            background-color: #fef9c3 !important;
        }
        .badge {
            display: inline-block;
            background-color: #eab308;
            color: white;
            font-size: 8px;
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 4px;
            margin-left: 5px;
            vertical-align: middle;
        }
        .delta {
            display: block;
            font-size: 9px;
            margin-top: 5px;
        }
        .delta.positive { color: #16a34a; }
        .delta.negative { color: #dc2626; }
        .delta.neutral { color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reef Malaysia Sales</h1>
        <p>Report Period: <strong>{{ $periodLabel }}</strong></p>
    </div>

    <table class="kpi-container">
        <tr>
            <td>
                <span class="kpi-title">Total Revenue</span>
                <span class="kpi-value">RM{{ number_format($monthRevenue, 2) }}</span>
                <span class="delta {{ Str::startsWith($deltas['revenue'], '+') ? 'positive' : (Str::startsWith($deltas['revenue'], '-') ? 'negative' : 'neutral') }}">
                    {{ $deltas['revenue'] }} {{ $deltas['label'] }}
                </span>
            </td>
            <td>
                <span class="kpi-title">Units Sold</span>
                <span class="kpi-value">{{ number_format($monthUnitsSold) }}</span>
                <span class="delta {{ Str::startsWith($deltas['units'], '+') ? 'positive' : (Str::startsWith($deltas['units'], '-') ? 'negative' : 'neutral') }}">
                    {{ $deltas['units'] }} {{ $deltas['label'] }}
                </span>
            </td>
            <td>
                <span class="kpi-title">Total Transactions</span>
                <span class="kpi-value">{{ number_format($monthTransactions) }}</span>
                <span class="delta {{ Str::startsWith($deltas['txs'], '+') ? 'positive' : (Str::startsWith($deltas['txs'], '-') ? 'negative' : 'neutral') }}">
                    {{ $deltas['txs'] }} {{ $deltas['label'] }}
                </span>
            </td>
        </tr>
    </table>

    <div class="section-title">Sales by Product</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-center">Vol.</th>
                <th class="text-center">Total Qty Sold</th>
                <th class="text-right">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesByProduct as $item)
                <tr class="{{ $loop->iteration <= 5 ? 'highlight-row' : '' }}">
                    <td>
                        {{ $item->product->name }}
                        @if($loop->iteration <= 5)
                            <span class="badge">#{{ $loop->iteration }}</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->product->volume_ml }}ml</td>
                    <td class="text-center">{{ number_format($item->total_qty) }}</td>
                    <td class="text-right">RM{{ number_format($item->total_rev, 2) }}</td>
                </tr>
            @endforeach
            @if($salesByProduct->isEmpty())
                <tr>
                    <td colspan="4" class="text-center" style="padding: 20px; color: #94a3b8;">
                        No product sales records found.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="section-title">Reseller Performance</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Reseller Name</th>
                <th class="text-center">Transactions</th>
                <th class="text-center">Total Qty Sold</th>
                <th class="text-right">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesByReseller as $reseller)
                <tr class="{{ $loop->iteration <= 5 ? 'highlight-row' : '' }}">
                    <td>
                        {{ $reseller->user->name }}
                        @if($loop->iteration <= 5)
                            <span class="badge">#{{ $loop->iteration }}</span>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($reseller->tx_count) }}</td>
                    <td class="text-center">{{ number_format($reseller->total_qty) }}</td>
                    <td class="text-right">RM{{ number_format($reseller->total_rev, 2) }}</td>
                </tr>
            @endforeach
            @if($salesByReseller->isEmpty())
                <tr>
                    <td colspan="4" class="text-center" style="padding: 20px; color: #94a3b8;">
                        No reseller sales records found.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Generated by RPIMS System on {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}
    </div>

</body>
</html>
