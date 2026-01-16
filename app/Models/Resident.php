<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Unit;

class Resident extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'unit_id',
        'name',
        'ic_no',
        'phone',
        'email',
        'type',
        'status',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}