<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentReceiptController extends Controller
{
    public function __invoke(Payment $payment)
    {
        $payment->load(['invoice', 'unit', 'receiver']);

        $pdf = Pdf::loadView('receipts.payment', [
            'payment' => $payment,
        ]);

        return $pdf->stream(
            'receipt-' . $payment->receipt_no . '.pdf'
        );
    }
}
