<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- Import this

class Merchandise extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'merchandise';

    protected $fillable = [
        'name',
        'stock',
        'price_per_pcs',
        'stock_date',
    ];

    protected $casts = [
        'stock' => 'integer',
        'price_per_pcs' => 'decimal:3',
        'stock_date' => 'date',
    ];

    /**
     * Accessor to automatically calculate the total_price.
     * This creates a "virtual" attribute, so you don't need a database column for it.
     */
    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stock * $this->price_per_pcs,
        );
    }
}