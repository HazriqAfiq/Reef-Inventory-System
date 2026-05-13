<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales & Performance Report</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            color: #0f172a;
            margin: 0;
            padding: 20px;
            font-size: 10px;
            line-height: 1.4;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 15px;
        }
        .header-title {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header-subtitle {
            font-size: 8px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 3px;
        }
        .header-meta {
            text-align: right;
            font-size: 9px;
            color: #334155;
            line-height: 1.4;
        }
        .section-title {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #0f172a;
            border-bottom: 1px solid #0f172a;
            padding-bottom: 3px;
            margin-top: 20px;
            margin-bottom: 10px;
            page-break-after: avoid;
        }
        /* KPI Cards Table */
        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-left: -10px;
            margin-right: -10px;
            margin-bottom: 15px;
        }
        .kpi-card {
            width: 33.33%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 8px;
            vertical-align: top;
        }
        .kpi-label {
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .kpi-subtext {
            font-size: 8px;
            color: #64748b;
        }
        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .details-table th {
            background: #f8fafc;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #334155;
            padding: 8px 10px;
            border-bottom: 1px solid #94a3b8;
            text-align: left;
        }
        .details-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
            color: #334155;
        }
        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .font-black {
            font-weight: 850;
            color: #0f172a;
        }
        .text-rose {
            color: #b91c1c;
            font-weight: bold;
        }
        .text-emerald {
            color: #15803d;
            font-weight: bold;
        }
        .text-indigo {
            color: #4338ca;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 7px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #cbd5e1;
        }
        .badge-rose {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fee2e2;
        }
        .badge-amber {
            background: #fffbeb;
            color: #92400e;
            border-color: #fef3c7;
        }
        .badge-emerald {
            background: #f0fdf4;
            color: #166534;
            border-color: #dcfce7;
        }
        .page-break {
            page-break-before: always;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            page-break-after: avoid;
        }
    </style>
</head>
<body>

    <!-- Report Header -->
    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">Sales & Performance Report</div>
                <div class="header-subtitle">Reef Store Headquarters &middot; Operational Live Ledger</div>
            </td>
            <td class="header-meta">
                <strong>Access Level:</strong> SYSTEM ADMINISTRATOR<br>
                <strong>System ID:</strong> {{ auth()->user()->name }}<br>
                <strong>Date Generated:</strong> {{ now()->format('F d, Y @ h:i A') }}
            </td>
        </tr>
    </table>

    <!-- Section 1: Sales Summary KPIs -->
    <div class="section-title">Executive Sales & Revenue Summary</div>
    <table class="kpi-table">
        <tr>
            <!-- Card 1 -->
            <td class="kpi-card">
                <div class="kpi-label">Total Sales Revenue</div>
                <div class="kpi-value text-emerald">RM{{ number_format($totalPaidRevenue, 2) }}</div>
                <div class="kpi-subtext">Cumulative revenue collected from non-cancelled wholesale orders.</div>
            </td>
            <!-- Card 2 -->
            <td class="kpi-card">
                <div class="kpi-label">Average Order Value</div>
                <div class="kpi-value">RM{{ number_format($averageOrderValue, 2) }}</div>
                <div class="kpi-subtext">Mean checkout cart value per wholesale reseller purchase.</div>
            </td>
            <!-- Card 3 -->
            <td class="kpi-card">
                <div class="kpi-label">Current Cycle Velocity</div>
                <div class="kpi-value text-indigo">RM{{ number_format($currentMonthRevenue, 2) }}</div>
                <div class="kpi-subtext">Collected RM{{ number_format($currentMonthRevenue, 2) }} across {{ $currentMonthOrders }} orders this month.</div>
            </td>
        </tr>
    </table>

    <!-- Section 2: Order Pipeline Distribution -->
    <div class="section-title">Wholesale Pipeline Matrix</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>Status Bracket</th>
                <th class="text-center">Active Pipelines</th>
                <th class="text-right">Value Weighted</th>
                <th>Sourcing Interpretation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderStats as $status => $data)
                <tr>
                    <td>
                        <span class="badge {{ $status === 'paid' || $status === 'delivered' ? 'badge-emerald' : ($status === 'cancelled' ? 'badge-rose' : 'badge-amber') }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="text-center font-black">{{ number_format($data['count']) }} orders</td>
                    <td class="text-right font-black">RM{{ number_format($data['total'], 2) }}</td>
                    <td>
                        @if($status === 'pending')
                            Awaiting reseller payments.
                        @elseif($status === 'paid')
                            Fully paid and awaiting inventory dispatch.
                        @elseif($status === 'processing')
                            Packaging and preparing for courier handover.
                        @elseif($status === 'shipped')
                            In transit with logistics carriers.
                        @elseif($status === 'delivered')
                            Sourcing cycle successfully concluded.
                        @else
                            Orders abandoned or revoked.
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Section 3: Best Selling Fragrances -->
    <div class="section-title">Best-Selling Perfume Leaderboard</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product Profile Name</th>
                <th class="text-center">Stock Available</th>
                <th class="text-center">Units Sold</th>
                <th class="text-right">Revenue Generated</th>
                <th class="text-right">Market Share</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bestSellingProducts->take(10) as $index => $prod)
                <tr>
                    <td class="font-black">{{ $prod->sku }}</td>
                    <td><strong>{{ $prod->name }}</strong> ({{ $prod->volume_ml }}ml)</td>
                    <td class="text-center">
                        @if($prod->stock == 0)
                            <span class="text-rose">Out of Stock</span>
                        @else
                            {{ number_format($prod->stock) }} units
                        @endif
                    </td>
                    <td class="text-center font-black">{{ number_format($prod->total_qty_sold ?? 0) }}</td>
                    <td class="text-right font-black">RM{{ number_format($prod->total_revenue ?? 0, 2) }}</td>
                    <td class="text-right font-black text-indigo">{{ number_format($prod->revenue_share, 1) }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No sales entries cataloged yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- Section 4: Reseller Spend Registry -->
    <div class="section-title" style="margin-top: 0;">Reseller Engagement Registry</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>Reseller Registered Profile</th>
                <th>Contact Address</th>
                <th class="text-center">Wholesale Orders</th>
                <th class="text-right">Total Procured Spend</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topResellers as $reseller)
                <tr>
                    <td><strong>{{ $reseller->name }}</strong></td>
                    <td>{{ $reseller->email }}</td>
                    <td class="text-center font-black">{{ number_format($reseller->orders_count) }}</td>
                    <td class="text-right font-black text-emerald">RM{{ number_format($reseller->total_spend ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No registered reseller partners in database ledger.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section 5: Critically Dormant Resellers -->
    <div class="section-title">Dormant Partner Alerts (60+ Days Inactive)</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>Dormant Reseller Name</th>
                <th>Email Address</th>
                <th class="text-center">Days Inactive</th>
                <th class="text-right">Last Procurement Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dormantResellers as $reseller)
                <tr>
                    <td><strong class="text-rose">{{ $reseller->name }}</strong></td>
                    <td>{{ $reseller->email }}</td>
                    <td class="text-center font-black">
                        @if($reseller->last_order_date)
                            {{ now()->diffInDays(\Carbon\Carbon::parse($reseller->last_order_date)) }} days
                        @else
                            Infinite (All-time)
                        @endif
                    </td>
                    <td class="text-right font-black text-rose">
                        {{ $reseller->last_order_date ? \Carbon\Carbon::parse($reseller->last_order_date)->format('Y-m-d') : 'Never' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-emerald">All registered reseller partners are active and sourcing stock.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section 6: Inventory Alert System -->
    <div class="section-title">Critical Inventory Alerts</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>Alert Level</th>
                <th>Product SKU</th>
                <th>Fragrance Profile Details</th>
                <th class="text-center">Current stock count</th>
                <th>Operational Recommendation</th>
            </tr>
        </thead>
        <tbody>
            <!-- Out of Stock -->
            @foreach($outOfStock as $item)
                <tr>
                    <td><span class="badge badge-rose">Out of Stock</span></td>
                    <td class="font-black">{{ $item->sku }}</td>
                    <td><strong>{{ $item->name }}</strong> ({{ $item->volume_ml }}ml)</td>
                    <td class="text-center font-black text-rose">0 units</td>
                    <td class="text-rose font-black">IMMEDIATE FACTORY REPLENISHMENT REQUIRED.</td>
                </tr>
            @endforeach
            <!-- Low Stock -->
            @foreach($lowStock->take(15) as $item)
                <tr>
                    <td><span class="badge badge-amber">Low Stock Alert</span></td>
                    <td class="font-black">{{ $item->sku }}</td>
                    <td>{{ $item->name }} ({{ $item->volume_ml }}ml)</td>
                    <td class="text-center font-black text-indigo">{{ $item->stock }} units</td>
                    <td>Monitor demand; line up restock batch if velocity spikes.</td>
                </tr>
            @endforeach
            @if($outOfStock->isEmpty() && $lowStock->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-emerald">Inventory reservoirs are healthy and above warning thresholds.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Report Footer -->
    <div class="footer">
        Confidential Asset &middot; Reef Store Central Executive &copy; {{ now()->year }} &middot; All Rights Reserved
    </div>

</body>
</html>
