<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <-- Add this


class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "slug",
        "thumbnail",
        "about",
        "category_id",
        "brand_id",
        "price",
        'stock',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = $value;
        $this->attributes["slug"] = Str::slug($value);
    }

    protected $casts = [
        "price"=> MoneyCast::class,
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'product_store', 'product_id', 'store_id')
            ->withPivot(['price', 'description', 'is_open', 'custom_dp_amount'])
            ->withTimestamps();
    }
}
