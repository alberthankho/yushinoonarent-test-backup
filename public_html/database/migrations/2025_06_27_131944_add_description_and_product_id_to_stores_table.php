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
            // Add a text column for the description
            $table->text('description')->nullable()->after('address');
    
            // Add the foreign key for the product
            // This will link a store to a product
            $table->foreignId('product_id')->nullable()->after('price')->constrained('products');
        });
    }
    
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // This allows the migration to be reversed safely
            $table->dropForeign(['product_id']);
            $table->dropColumn(['description', 'product_id']);
        });
    }
};
