<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Infinity Dental Lab - Doctor Statement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $faviconPath = public_path('images/favicon.png');
        $faviconData = '';
        if (file_exists($faviconPath)) {
            $faviconData = 'data:image/png;base64,' . base64_encode(file_get_contents($faviconPath));
        }
        
        $path = public_path('images/logo-light.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = @file_get_contents($path);
        $base64 = $data ? 'data:image/' . $type . ';base64,' . base64_encode($data) : '';
    @endphp
    <link rel="apple-touch-icon" href="{{ $faviconData }}">
    <link rel="icon" href="{{ $faviconData }}" type="image/png">
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', Arial, sans-serif;
            color: #334155;
            background-color: #ffffff;
            line-height: 1.5;
        }

        .container {
            width: 185mm;
            /* تقليل العرض قليلاً لزيادة الفخامة في الحواف */
            margin: 15mm auto;
            padding: 0;
        }

        /* Header Styling */
        .header-table {
            border-bottom: 3px solid #f1f5f9;
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .brand-name {
            font-size: 32px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 2px;
            margin: 0;
        }

        .brand-sub {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        /* Bill To Section */
        .info-table {
            margin-bottom: 40px;
        }

        .bill-to-box {
            background-color: #f8fafc;
            border-left: 5px solid #1e293b;
            border-radius: 0 12px 12px 0;
            padding: 20px;
        }

        .status-badge {
            background-color: #ecfdf5;
            color: #059669;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
            border: 1px solid #d1fae5;
        }

        /* Professional Items Table */
        .items-table {
            width: 100%;
            margin-top: 20px;
            border-radius: 12px;
            overflow: hidden;
            /* لا يعمل دائماً في PDF لذا نستخدم الحدود */
        }

        .items-table th {
            background-color: #1e293b;
            color: #ffffff;
            padding: 14px 12px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 12px;
            vertical-align: middle;
        }

        .items-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Financial Summary */
        .summary-wrapper {
            margin-top: 30px;
            width: 100%;
        }

        .summary-table {
            width: 280px;
            float: right;
        }

        .summary-table td {
            padding: 8px 0;
            font-size: 13px;
        }

        .total-row td {
            padding-top: 15px;
            border-top: 2px solid #0f172a;
            font-weight: bold;
            font-size: 18px;
            color: #b91c1c;
            /* أحمر احترافي للرصيد المتبقي */
        }

        .currency {
            color: #94a3b8;
            font-size: 11px;
            margin-right: 2px;
        }

        /* Footer Decoration */
        .footer-note {
            margin-top: 100px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <div class="container">
        <table class="header-table" style="width: 100%;">
            <tr>
                <td style="width: 180px;">
                    @if($base64)
                        <img src="{{ $base64 }}" style="width: 160px; height: auto; display: block;">
                    @else
                        <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 10px;"></div>
                    @endif
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <h1 class="brand-name">INFINITY</h1>
                    <div class="brand-sub">Professional Dental Laboratory</div>
                </td>
            </tr>
        </table>

        <table class="info-table" style="width: 100%;">
            <tr>
                <td style="width: 60%;">
                    <div class="bill-to-box">
                        <small
                            style="color: #64748b; font-weight: bold; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Bill
                            To</small>
                        <div style="font-size: 22px; font-weight: bold; color: #0f172a; margin-top: 5px;">Dr.
                            {{ $doctor->name }}</div>
                        <div style="color: #64748b; font-size: 12px; margin-top: 3px;">Dental Specialist / Clinic</div>
                    </div>
                </td>
                <td style="text-align: right; vertical-align: top; padding-top: 10px;">
                    <div class="status-badge">ACTIVE ACCOUNT</div>
                    <div style="margin-top: 15px;">
                        <small style="color: #64748b; font-weight: bold; font-size: 10px;">ISSUE DATE</small>
                        <div style="font-size: 15px; font-weight: bold; color: #0f172a; margin-top: 3px;">{{ $date }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 12%; text-align: left; border-radius: 10px 0 0 0;">Date</th>
                    <th style="width: 35%; text-align: left;">Service Description</th>
                    <th style="width: 8%; text-align: center;">Qty</th>
                    <th style="width: 12%; text-align: left;">Unit Price</th>
                    <th style="width: 12%; text-align: left;">Design Price</th>
                    <th style="width: 12%; text-align: right; border-radius: 0 10px 0 0;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="color: #64748b;">{{ $item->created_at->format('d M, Y') }}</td>
                        <td style="font-weight: bold; color: #1e293b;">{{ $item->material->name }}</td>
                        <td style="text-align: center; color: #0f172a; font-weight: bold;">{{ $item->quantity }}</td>
                        <td><span class="currency">USD</span>{{ number_format($item->unit_price, 2) }}</td>
                        <td>
                            @if($item->design_price > 0)
                                <span class="currency">USD</span>{{ number_format($item->design_price, 2) }}
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                        <td style="text-align: right; font-weight: bold; color: #0f172a;">
                            <span class="currency">USD</span>{{ number_format($item->total_price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td style="color: #64748b;">Items Subtotal</td>
                    <td style="text-align: right; font-weight: bold;">${{ number_format($totalItemsPrice, 2) }}</td>
                </tr>
                <!-- <tr>
                    <td style="color: #64748b;">Design Charges</td>
                    <td style="text-align: right; font-weight: bold;">
                        @php
                            $totalDesignPrice = $items->sum('design_price');
                        @endphp
                        ${{ number_format($totalDesignPrice, 2) }}
                    </td>
                </tr> -->
                <tr>
                    <td style="color: #059669;">Total Paid (Partial)</td>
                    <td style="text-align: right; font-weight: bold; color: #059669;">-
                        ${{ number_format($payments, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Balance Due</td>
                    <td style="text-align: right;">${{ number_format($remainingBalance, 2) }}</td>
                </tr>
            </table>
            <div style="clear: both;"></div>
        </div>

        <div class="footer-note">
            <p>This is a computer-generated document from Infinity Dental Lab.</p>
            <p style="font-weight: bold;">Thank you for your business!</p>
        </div>
    </div>

</body>

</html>