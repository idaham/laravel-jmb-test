<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'amount',
        'sort_order',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted()
    {
        static::saved(function (InvoiceItem $item) {
            $item->invoice->recalculateTotal();
        });

        static::deleted(function (InvoiceItem $item) {
            $item->invoice->recalculateTotal();
        });
    }

}
