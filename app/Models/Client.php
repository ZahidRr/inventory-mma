<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number',
        'name',
        'phone',
        'package',
        'sales_name',
        'status',
        'serial_number_id',
    ];

    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class);
    }
}