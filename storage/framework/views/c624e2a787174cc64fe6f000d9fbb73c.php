<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reseller Performance Report</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, Georgia, serif;
            color: #0f172a;
            margin: 0;
            padding: 20px;
            font-size: 11px;
            line-height: 1.5;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .header-title {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header-subtitle {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 3px;
        }
        .header-meta {
            text-align: right;
            font-size: 10px;
            color: #334155;
            line-height: 1.4;
        }
        .section-title {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #0f172a;
            border-bottom: 1px solid #0f172a;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        /* KPI Cards Table */
        .kpi-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 0;
            margin-left: -12px;
            margin-right: -12px;
            margin-bottom: 20px;
        }
        .kpi-card {
            width: 33.33%;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 16px;
            border-radius: 12px;
            vertical-align: top;
        }
        .kpi-label {
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .kpi-value {
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .kpi-subtext {
            font-size: 8px;
            color: #475569;
            font-weight: 500;
        }
        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .details-table th {
            background: #f8fafc;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #475569;
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        .details-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 10px;
            color: #334155;
        }
        .text-right {
            text-align: right !important;
        }
        .font-black {
            font-weight: 800;
            color: #0f172a;
        }
        .text-rose {
            color: #e11d48;
            font-weight: bold;
        }
        .text-emerald {
            color: #059669;
            font-weight: bold;
        }
        .text-indigo {
            color: #4f46e5;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-rose {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #ffe4e6;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <!-- Report Header -->
    <table class="header-table">
        <tr>
            <td>
                <div class="header-title">Partner Performance Report</div>
                <div class="header-subtitle">Reef Store Reseller Network &middot; Live Ledger</div>
            </td>
            <td class="header-meta">
                <strong>Reseller Name:</strong> <?php echo e($user->name); ?><br>
                <strong>Email Address:</strong> <?php echo e($user->email); ?><br>
                <strong>Date Generated:</strong> <?php echo e(now()->format('F d, Y @ h:i A')); ?>

            </td>
        </tr>
    </table>

    <!-- Section 1: Executive KPI Metrics -->
    <div class="section-title">Executive Sourcing & Performance Summary</div>
    <table class="kpi-table">
        <tr>
            <!-- Card 1 -->
            <td class="kpi-card">
                <div class="kpi-label">Wholesale Investment</div>
                <div class="kpi-value">RM<?php echo e(number_format($totalProcurementSpend, 2)); ?></div>
                <div class="kpi-subtext">Total capital spent across <?php echo e($totalSourcedOrders); ?> wholesale stock restocks.</div>
            </td>
            <!-- Card 2 -->
            <td class="kpi-card">
                <div class="kpi-label">Active Shelf Stocks</div>
                <div class="kpi-value"><?php echo e(number_format($totalStockUnits)); ?> units</div>
                <div class="kpi-subtext">Total inventory bottles physically held on reseller shelves.</div>
            </td>
            <!-- Card 3 -->
            <td class="kpi-card">
                <div class="kpi-label">Estimated Profits</div>
                <div class="kpi-value text-rose">+RM<?php echo e(number_format($potentialProfitMargin, 2)); ?></div>
                <div class="kpi-subtext">Average margin potential of <?php echo e(number_format($averageMarginPercentage, 1)); ?>% at recommended RSP.</div>
            </td>
        </tr>
    </table>

    <!-- Section 2: Asset Valuations & Goals -->
    <div class="section-title">Financial Audit & Sourcing Goals</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>Financial Performance Metric</th>
                <th class="text-right">Ledger Value</th>
                <th>Sourcing Status / Interpretation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Total Sourced Investment (Overall)</strong></td>
                <td class="text-right font-black">RM<?php echo e(number_format($totalProcurementSpend, 2)); ?></td>
                <td>Cumulative capital invested on product replenishments.</td>
            </tr>
            <tr>
                <td><strong>Average Sourced Order Value</strong></td>
                <td class="text-right font-black">RM<?php echo e(number_format($averageOrderValue, 2)); ?></td>
                <td>Average order size when placing wholesale restock requests.</td>
            </tr>
            <tr>
                <td><strong>This Month's Procurement Spend</strong></td>
                <td class="text-right font-black">RM<?php echo e(number_format($currentMonthSpend, 2)); ?></td>
                <td>
                    Restocked <span class="text-indigo"><?php echo e($goalProgress); ?>%</span> of 
                    RM<?php echo e(number_format($monthlyGoal, 2)); ?> monthly target spend.
                </td>
            </tr>
            <tr>
                <td><strong>Shelf Inventory Valuation (At Cost)</strong></td>
                <td class="text-right font-black">RM<?php echo e(number_format($stockValuationCost, 2)); ?></td>
                <td>Current cost value of goods sitting in stock.</td>
            </tr>
            <tr>
                <td><strong>Shelf Inventory Valuation (At Retail RSP)</strong></td>
                <td class="text-right font-black text-indigo">RM<?php echo e(number_format($stockValuationRetail, 2)); ?></td>
                <td>Cumulative potential sales revenue of stocks on shelf.</td>
            </tr>
            <tr>
                <td><strong>Potential Profit Margins (Gross)</strong></td>
                <td class="text-right font-black text-emerald">RM<?php echo e(number_format($potentialProfitMargin, 2)); ?></td>
                <td>
                    <span class="badge badge-rose">
                        <?php echo e(number_format($averageMarginPercentage, 1)); ?>% Average ROI
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Section 3: Top Sourced Products -->
    <div class="section-title">Top Replenished Fragrance Items</div>
    <table class="details-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th class="text-right">Sourced Qty</th>
                <th class="text-right">Unit Cost (WSP)</th>
                <th class="text-right">Unit Retail (RSP)</th>
                <th class="text-right">Potential Margin</th>
                <th class="text-right">Total Invested</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $topSourcedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($item->product): ?>
                    <?php
                        $unitProfit = $item->product->retail_price - $item->product->wholesale_price;
                        $unitProfitPercent = $item->product->retail_price > 0 ? ($unitProfit / $item->product->retail_price) * 100 : 0;
                    ?>
                    <tr>
                        <td><strong><?php echo e($item->product->name); ?></strong> (<?php echo e($item->product->volume_ml); ?>ml)</td>
                        <td><?php echo e(optional($item->product->category)->name ?: '—'); ?></td>
                        <td class="text-right font-black"><?php echo e(number_format($item->total_qty)); ?> units</td>
                        <td class="text-right">RM<?php echo e(number_format($item->product->wholesale_price, 2)); ?></td>
                        <td class="text-right text-indigo">RM<?php echo e(number_format($item->product->retail_price, 2)); ?></td>
                        <td class="text-right text-emerald">
                            +RM<?php echo e(number_format($unitProfit, 2)); ?>

                            <div style="font-size: 7px; color: #10b981;">(<?php echo e(number_format($unitProfitPercent, 1)); ?>%)</div>
                        </td>
                        <td class="text-right font-black">RM<?php echo e(number_format($item->total_spend, 2)); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #94a3b8; padding: 25px;">
                        No product replenishment records detected in ledger files.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Report Footer -->
    <div class="footer">
        Confidential Document &middot; Reef Store Reseller Portal &copy; <?php echo e(now()->year); ?> &middot; All Rights Reserved
    </div>

</body>
</html>
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/reseller/reports/pdf.blade.php ENDPATH**/ ?>