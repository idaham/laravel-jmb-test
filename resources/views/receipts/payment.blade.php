<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt {{ $payment->receipt_no }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

<div class="header">
    <strong>JMB ABC RESIDENCE</strong><br>
    Jalan Contoh 123<br>
    43000 Kajang, Selangor<br>
</div>

<div class="title">OFFICIAL RECEIPT</div>

<div class="section">
    <table>
        <tr>
            <td>Receipt No</td>
            <td>: {{ $payment->receipt_no }}</td>
            <td class="right">Date</td>
            <td class="right">: {{ $payment->payment_date->format('d M Y') }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Bill To</div>
    {{ $payment->invoice->owner_name ?? '—' }}<br>
    Unit {{ $payment->unit->display_name }}
</div>

<div class="section">
    <div class="section-title">Invoice</div>
    Invoice No : {{ $payment->invoice->invoice_no }}<br>
    Billing    : {{ $payment->invoice->billing_period }}
</div>

<div class="section">
    <div class="section-title">Payment Details</div>

    <table>
        <tr>
            <td>Method</td>
            <td>: {{ ucfirst($payment->method) }}</td>
        </tr>

        @if($payment->reference_no)
        <tr>
            <td>Reference</td>
            <td>: {{ $payment->reference_no }}</td>
        </tr>
        @endif

        <tr>
            <td>Amount</td>
            <td>: RM {{ number_format($payment->amount, 2) }}</td>
        </tr>
    </table>
</div>

<div class="section total">
    Total Paid : RM {{ number_format($payment->amount, 2) }}
</div>

<div class="section">
    Received By : {{ optional($payment->receiver)->name ?? '-' }}<br>
    Recorded At : {{ $payment->created_at->format('d M Y H:i') }}
</div>

<div class="footer">
    This is a system-generated receipt. No signature required.
</div>

</body>
</html>