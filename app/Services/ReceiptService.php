<?php
// app/Services/ReceiptService.php
namespace App\Services;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptService
{
    public function streamPaymentReceipt(Payment $payment)
    {
        $payment->loadMissing(['invoice', 'unit', 'receiver']);

        return Pdf::loadView('receipts.payment', [
            'payment' => $payment,
        ])->stream('receipt-' . $payment->receipt_no . '.pdf');
    }
}
