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
        Schema::table('k_y_c_field_masters', function (Blueprint $table) {
            $table->json('visible_countries')->nullable()->after('visible_to_partner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_y_c_field_masters', function (Blueprint $table) {
            $table->dropColumn('visible_countries');
        });
    }
};
