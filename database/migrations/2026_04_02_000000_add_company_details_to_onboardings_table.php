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
        Schema::table('onboardings', function (Blueprint $table) {
            // Add company detail fields after registration_number
            $table->string('tax_id_vat')->nullable()->after('registration_number');
            $table->string('dba_address')->nullable()->after('tax_id_vat');
            $table->string('dba_zip_code')->nullable()->after('dba_address');
            $table->string('dba_city')->nullable()->after('dba_zip_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onboardings', function (Blueprint $table) {
            $table->dropColumn(['tax_id_vat', 'dba_address', 'dba_zip_code', 'dba_city']);
        });
    }
};
