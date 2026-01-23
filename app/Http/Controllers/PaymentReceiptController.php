<?php

namespace App\Http\Controllers;

use App\Services\ReceiptService;
use App\Models\Payment; 

class PaymentReceiptController extends Controller
{
    public function __invoke(Payment $payment, ReceiptService $service)
    {
        return $service->streamPaymentReceipt($payment);
    }
}
