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
        Schema::table('transactions', function (Blueprint $table) {
            // Add the new amount columns after 'total_amount'
            $table->bigInteger('dp_amount')->nullable()->after('total_amount');
            $table->bigInteger('materai_amount')->nullable()->after('dp_amount');
            $table->bigInteger('unpaid_amount')->nullable()->after('materai_amount');
        });
    }
    
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['dp_amount', 'materai_amount', 'unpaid_amount']);
        });
    }
};
