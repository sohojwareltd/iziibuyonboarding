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
            $table->dropUnique('k_y_c_field_masters_field_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_y_c_field_masters', function (Blueprint $table) {
            $table->unique('field_name');
        });
    }
};
