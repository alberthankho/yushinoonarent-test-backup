<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Existing fields
        "name",
        "trx_id",
        "proof",
        "phone_number",
        "address",
        "total_amount",
        "product_id",
        "store_id",
        "duration",
        "is_paid",
        "delivery_type",
        "started_at",
        "ended_at",

        // Newly added fields from the migration
        "nik",
        "email",
        "tenants_address_ktp",
        "tenants_address_domicile",
        "event_rent_session",
        "first_identification_type",
        "second_identification_type",
        "second_identification_value",
        "twitter",
        "instagram",
        "guarantor_name",
        "relationship_with_guarantor",
        "guarantor_phone",
        "dp_amount",
        "materai_amount",
        "unpaid_amount",
        "is_dp_paid",
        "midtrans_fee",
        "referal_fee",
        "expense_fee",
    ];

    protected $casts = [
        "total_amount"=> MoneyCast::class,
        'started_at' => 'date',
        'ended_at'=> 'date',
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'RBYN';
        do {
            $randomString = $prefix . mt_rand(1000,9999);
        } while (self::where('trx_id', $randomString)->exists());

        return $randomString;
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class)->withTrashed();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function ticketScreenshots(): HasMany
    {
        return $this->hasMany(TransactionTicketScreenshot::class);
    }

    public function userIdentifications(): HasMany
    {
        return $this->hasMany(TransactionUserIdentification::class);
    }

    public function userSelfies(): HasMany
    {
        return $this->hasMany(TransactionUserSelfie::class);
    }

    public function productReturns(): HasMany
    {
        return $this->hasMany(TransactionProductReturn::class);
    }
    
    public function buktiPelunasans(): HasMany
    {
        return $this->hasMany(TransactionBuktiPelunasan::class);
    }
}
