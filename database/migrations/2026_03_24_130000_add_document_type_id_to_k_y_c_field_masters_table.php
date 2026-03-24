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
            $table->foreignId('document_type_id')
                ->nullable()
                ->after('data_type')
                ->constrained('document_types_masters')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('k_y_c_field_masters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('document_type_id');
        });
    }
};