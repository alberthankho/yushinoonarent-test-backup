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
    Schema::table('transaction_ticket_screenshots', function (Blueprint $table) {
        $table->softDeletes();
    });
    Schema::table('transaction_user_identifications', function (Blueprint $table) {
        $table->softDeletes();
    });
    Schema::table('transaction_user_selfies', function (Blueprint $table) {
        $table->softDeletes();
    });
    Schema::table('transaction_product_returns', function (Blueprint $table) {
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::table('transaction_ticket_screenshots', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
    Schema::table('transaction_user_identifications', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
    Schema::table('transaction_user_selfies', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
    Schema::table('transaction_product_returns', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
    // ... and so on for the other tables
}
};
