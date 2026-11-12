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
        Schema::table('product_store', function (Blueprint $table) {
            // Nullable because not all products in a special store might have custom DPs
            $table->unsignedBigInteger('custom_dp_amount')->nullable()->after('is_open');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_store', function (Blueprint $table) {
            $table->dropColumn('custom_dp_amount');
        });
    }
};
