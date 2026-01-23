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

    public function recalculateTotals(): void
    {
        $this->total_amount = $this->items()->sum('amount');
        $this->save();
    }

    //public function totalPaid(): float
    //{
    //    return $this->payments()->sum('amount');
    //}
    public function getPaidAmountAttribute(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function getBalanceAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->paid_amount);
    }

    public function refreshStatus(): void
    {
        //$paid = $this->totalPaid();
        $paid = $this->paid_amount;

        if ($paid <= 0) {
            $this->status = now()->gt($this->due_date)
                ? 'overdue'
                : 'issued';
        } elseif ($paid < $this->total_amount) {
            $this->status = 'partial';
        } else {
            $this->status = 'paid';
        }

        //$this->save();
        $this->saveQuietly();
    }

    public function canAcceptPayment(float $amount): bool
    {
        //return ($this->paid_amount + $amount) <= $this->total_amount;
        return $amount <= $this->balance_amount;
    }



}
