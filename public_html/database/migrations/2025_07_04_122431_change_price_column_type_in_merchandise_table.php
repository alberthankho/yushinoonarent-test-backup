<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('merchandise', function (Blueprint $table) {
            // Change the column to a decimal type
            $table->decimal('price_per_pcs', 8, 3)->default(0)->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('merchandise', function (Blueprint $table) {
            // This allows the change to be reversed
            $table->bigInteger('price_per_pcs')->default(0)->change();
        });
    }
};
