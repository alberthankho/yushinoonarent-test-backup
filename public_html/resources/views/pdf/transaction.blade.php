<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Details - {{ $transaction->trx_id }}</title>
    <style>
        body { 
            font-family: 'Helvetica', sans-serif; 
            margin: 0; 
            padding: 0;
            font-size: 12px; 
            color: #333;
        }
        .container { 
            width: 100%; 
            margin: 20px auto; 
            padding: 0 30px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }
        .header h1 { 
            margin: 0; 
            font-size: 24px; 
            font-weight: bold;
        }
        .header h2 { 
            margin: 5px 0 0; 
            font-size: 14px; 
            color: #555; 
            font-weight: normal;
        }
        .section-title { 
            font-size: 16px; 
            margin-top: 25px; 
            margin-bottom: 10px; 
            border-bottom: 1px solid #ddd; 
            padding-bottom: 8px; 
            font-weight: bold;
            color: #000;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        td { 
            padding: 8px 0; 
            border-bottom: 1px solid #f0f0f0;
            vertical-align: top; 
        }
        td.label { 
            font-weight: bold; 
            width: 180px; /* Fixed width for labels */
            color: #555;
        }
        .footer { 
            margin-top: 40px; 
            text-align: center; 
            font-size: 10px; 
            color: #888; 
        }
        .text-right { 
            text-align: right; 
        }
        .total-row td {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Transaction Receipt</h1>
            <h2>Order ID: {{ $transaction->trx_id ?? 'N/A' }}</h2>
        </div>

        <div class="content">
            <div class="section-title">Customer Information</div>
            <table>
                <tr>
                    <td class="label">Name:</td>
                    <td>{{ $transaction->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td>{{ $transaction->phone_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Instagram:</td>
                    <td>{{ $transaction->instagram ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Twitter / X:</td>
                    <td>{{ $transaction->twitter ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Identification Documents:</td>
                    <td>
                        {{ $transaction->first_identification_type ?? 'N/A' }} & 
                        {{ $transaction->second_identification_type ?? 'N/A' }}
                        @if($transaction->second_identification_type === 'Others' && $transaction->second_identification_value)
                            ({{ $transaction->second_identification_value }})
                        @endif
                    </td>
                </tr>
            </table>

            <div class="section-title">Order Details</div>
            <table>
                <tr>
                    <td class="label">Product:</td>
                    <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Event / Store:</td>
                    <td>{{ $transaction->store->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Duration:</td>
                    <td>{{ $transaction->duration ?? 'N/A' }} Day(s)</td>
                </tr>
                <tr>
                    <td class="label">Started At:</td>
                    <td>{{ $transaction->started_at ? \Carbon\Carbon::parse($transaction->started_at)->format('d F Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Ended At:</td>
                    <td>{{ $transaction->ended_at ? \Carbon\Carbon::parse($transaction->ended_at)->format('d F Y') : 'N/A' }}</td>
                </tr>
            </table>

            <div class="section-title">Payment Information</div>
            <table>
                <tr>
                    <td class="label">Total Amount:</td>
                    <td class="text-right">Rp {{ number_format($transaction->total_amount ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Down Payment (DP):</td>
                    <td class="text-right">Rp {{ number_format($transaction->dp_amount ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Materai Fee:</td>
                    <td class="text-right">Rp {{ number_format($transaction->materai_amount ?? 0, 0, ',', '.') }}</td>
                </tr>
                 <tr class="total-row">
                    <td class="label">Unpaid Amount:</td>
                    <td class="text-right">Rp {{ number_format($transaction->unpaid_amount ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">DP Status:</td>
                    <td class="text-right">{{ ($transaction->is_dp_paid ?? false) ? 'Paid' : 'Not Paid' }}</td>
                </tr>
                <tr>
                    <td class="label">Final Payment Status:</td>
                    <td class="text-right">{{ ($transaction->is_paid ?? false) ? 'Paid' : 'Not Paid' }}</td>
                </tr>
                <tr>
                    <td class="label">Transaction Date:</td>
                    <td class="text-right">{{ $transaction->created_at ? \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') : 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for your business! - Rental by Yushi's Noona</p>
        </div>
    </div>
</body>
</html>
