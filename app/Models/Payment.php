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
        'amount',
        'payment_date',
        'method',
        'reference_no',
        'received_by',
        'remarks',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        static::saved(function (Payment $payment) {
            $payment->invoice->refreshStatus();
        });

        static::deleted(function (Payment $payment) {
            $payment->invoice->refreshStatus();
        });
    }

}
