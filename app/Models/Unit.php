<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Resident;
use App\Models\Invoice;

class Unit extends Model
{
    //
        use SoftDeletes;

        protected $fillable = [
            'block',
            'floor',
            'unit_no',
            'type',
            'size_sqft',
            'status',
        ];

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->block}-{$this->floor}-{$this->unit_no}";
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query
                ->orderBy('block')
                ->orderBy('floor')
                ->orderBy('unit_no');
        });
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
