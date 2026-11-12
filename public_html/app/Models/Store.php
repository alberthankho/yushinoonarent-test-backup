<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "slug",
        "is_open",
        'description',
        "is_special",
    ];

    public function setNameAttribute($value)
    {
        $this->attributes["name"] = $value;
        $this->attributes["slug"] = Str::slug($value);
    }
    
    protected $casts = [
        'is_open' => 'boolean',
        'is_special' => 'boolean',
    ];
    
    protected function eventDate(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // This regular expression looks for text between " - " and " ("
                preg_match('/- (.*?) \(/', $attributes['name'], $matches);

                // If no match is found, return null
                if (!isset($matches[1])) {
                    return null;
                }

                $dateString = trim($matches[1]);

                // Since your month names are in Indonesian, we need to translate them for Carbon
                $indonesianMonths = [
                    'Januari'   => 'January',
                    'Februari'  => 'February',
                    'Maret'     => 'March',
                    'April'     => 'April',
                    'Mei'       => 'May',
                    'Juni'      => 'June',
                    'Juli'      => 'July',
                    'Agustus'   => 'August',
                    'September' => 'September',
                    'Oktober'   => 'October',
                    'November'  => 'November',
                    'Desember'  => 'December',
                ];

                $englishDateString = str_replace(array_keys($indonesianMonths), array_values($indonesianMonths), $dateString);

                // Try to parse the date and return a Carbon object
                try {
                    return Carbon::parse($englishDateString);
                } catch (\Exception $e) {
                    return null; // Return null if the date format is unexpected
                }
            }
        );
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_store', 'store_id', 'product_id')
            ->withPivot(['price', 'description', 'is_open', 'custom_dp_amount'])
            ->withTimestamps();
    }
}
