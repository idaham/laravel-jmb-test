<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
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
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 15px;
        }

        .label {
            width: 140px;
            display: inline-block;
            font-weight: bold;
        }

        .value {
            display: inline-block;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="title">PAYMENT RECEIPT</div>
</div>

<div class="section">
    <div><span class="label">Receipt No:</span> <span class="value">{{ $payment->receipt_no }}</span></div>
    <div><span class="label">Receipt Date:</span> <span class="value">{{ $payment->created_at->format('d M Y') }}</span></div>
</div>

<div class="section">
    <div><span class="label">Invoice No:</span> <span class="value">{{ $payment->invoice->invoice_no }}</span></div>
    <div><span class="label">Unit:</span> <span class="value">{{ $payment->unit->display_name }}</span></div>
</div>

<div class="section">
    <div><span class="label">Payment Date:</span> <span class="value">{{ $payment->payment_date->format('d M Y') }}</span></div>
    <div><span class="label">Amount:</span> <span class="value">RM {{ number_format($payment->amount, 2) }}</span></div>
    <div><span class="label">Method:</span> <span class="value">{{ ucfirst($payment->method) }}</span></div>
    <div><span class="label">Reference:</span> <span class="value">{{ $payment->reference_no ?? '-' }}</span></div>
</div>

<div class="section">
    <div><span class="label">Received By:</span>
        <span class="value">{{ optional($payment->receiver)->name ?? 'System' }}</span>
    </div>
</div>

<div class="footer">
    This is a system generated receipt. No signature is required.
</div>

</body>
</html>
