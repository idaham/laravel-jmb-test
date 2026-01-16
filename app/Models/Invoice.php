<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\InvoiceItem;
use App\Models\Payment;

class Invoice extends Model
{
    protected $fillable = [
        'unit_id',
        'invoice_no',
        'billing_period',
        'issue_date',
        'due_date',
        'total_amount',
        'status',
        'created_by',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function recalculateTotal(): void
    {
        $this->total_amount = $this->items()->sum('amount');
        $this->save();
    }

    public function totalPaid(): float
    {
        return $this->payments()->sum('amount');
    }

    public function refreshStatus(): void
    {
        $paid = $this->totalPaid();

        if ($paid <= 0) {
            $this->status = now()->gt($this->due_date)
                ? 'overdue'
                : 'issued';
        } elseif ($paid < $this->total_amount) {
            $this->status = 'partial';
        } else {
            $this->status = 'paid';
        }

        $this->save();
    }

}
