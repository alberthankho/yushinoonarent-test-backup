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
        Schema::table('stores', function (Blueprint $table) {
            // Add the new price column after the 'address' column
            $table->bigInteger('price')->default(0)->after('address');
        });
    }
    
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // This allows the migration to be reversed if needed
            $table->dropColumn('price');
        });
    }
};
