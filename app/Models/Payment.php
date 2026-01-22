<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Unit;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'unit_id',
        'receipt_no',
        'amount',
        'payment_date',
        'method',
        'reference_no',
        'received_by',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'received_by');
    }

    protected static function booted()
    {
        static::creating(function (Payment $payment) {

            // 🔐 Generate receipt number
            if (empty($payment->receipt_no)) {
                $payment->receipt_no = self::generateReceiptNo();
            }

            // 🔗 Ensure unit_id is always set from invoice
            if (empty($payment->unit_id) && $payment->invoice) {
                $payment->unit_id = $payment->invoice->unit_id;
            }
        });

        // 🔄 Refresh invoice status AFTER payment is saved
        static::saved(function (Payment $payment) {
            $payment->invoice->refreshStatus();
        });

        //static::deleted(function (Payment $payment) {
        //    $payment->invoice->refreshStatus();
        //});
    }

    protected static function generateReceiptNo(): string
    {
        $prefix = 'RCT-' . now()->format('Ym');

        $latest = self::where('receipt_no', 'like', "{$prefix}-%")
            ->orderByDesc('receipt_no')
            ->value('receipt_no');

        $nextNumber = 1;

        if ($latest) {
            $lastSequence = (int) substr($latest, -5);
            $nextNumber = $lastSequence + 1;
        }

        return sprintf('%s-%05d', $prefix, $nextNumber);
    }

}
