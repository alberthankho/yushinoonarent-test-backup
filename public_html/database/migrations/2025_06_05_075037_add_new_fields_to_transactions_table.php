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
            // Place the new 'email' column first, after an existing column like 'phone_number'
            // (Assuming 'phone_number' is column 4 from your image, after 'trx_id', 'name', 'id')
            // If 'phone_number' doesn't exist, pick another valid existing column name like 'proof' or 'address'.
            $table->string('email')->nullable()->after('phone_number');

            // Now, place 'nik' after the newly defined 'email' column
            $table->string('nik')->nullable()->after('email');

            // Addresses
            $table->text('tenants_address_ktp')->nullable()->after('address');
            $table->text('tenants_address_domicile')->nullable()->after('tenants_address_ktp');

            // Event/Session Info
            $table->string('event_rent_session')->nullable()->after('tenants_address_domicile');

            // Identifications
            $table->enum('first_identification_type', ['KTP'])->default('KTP')->nullable()->after('event_rent_session');
            $table->enum('second_identification_type', [
                'SIM',
                'Paspor',
                'Kartu Pelajar/Mahasiswa/Pegawai',
                'STNK/BPKB',
                'Others'
            ])->nullable()->after('first_identification_type');
            $table->string('second_identification_value')->nullable()->after('second_identification_type');

            // Social Media
            $table->string('twitter')->nullable()->after('second_identification_value');
            $table->string('instagram')->nullable()->after('twitter');

            // Guarantor Information
            $table->string('guarantor_name')->nullable()->after('instagram');
            $table->string('relationship_with_guarantor')->nullable()->after('guarantor_name');
            $table->string('guarantor_phone')->nullable()->after('relationship_with_guarantor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'email', // Only if you added it here
                'tenants_address_ktp',
                'tenants_address_domicile',
                'event_rent_session',
                'first_identification_type',
                'second_identification_type',
                'second_identification_value',
                'twitter',
                'instagram',
                'guarantor_name',
                'relationship_with_guarantor',
                'guarantor_phone',
            ]);
        });
    }
};