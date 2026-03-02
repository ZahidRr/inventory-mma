<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['name', 'category', 'description'];

    // Relasi: Satu produk punya banyak Serial Number
    public function serialNumbers(): HasMany
    {
        return $this->hasMany(SerialNumber::class);
    }

    // Shortcut untuk menghitung stok yang tersedia (status MASUK)
    public function availableStock()
    {
        return $this->serialNumbers()->where('status', 'MASUK')->count();
    }
}
