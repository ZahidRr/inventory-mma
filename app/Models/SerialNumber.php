<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SerialNumber extends Model
{
    protected $fillable = [
        'product_id', 'serial_number', 'client_unit', 'status', 
        'technician', 'cable_length', 'work_date', 'installed_at',
        'client_name', 'phone_number', 'package_speed'
    ];

    protected $casts = [
        'work_date' => 'date',
        'installed_at' => 'datetime',
        'technician' => 'array', 
    ];

    public function setClientUnitAttribute($value)
    {
        $this->attributes['client_unit'] = strtoupper($value);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}