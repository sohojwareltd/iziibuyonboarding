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
        Schema::create('informations', function (Blueprint $table) {
            $table->id();
            $table->string('kyc_link');
            $table->foreignId('kyc_section_id')->constrained('kyc_sections')->cascadeOnDelete();
            $table->foreignId('kyc_field_master_id')->constrained('k_y_c_field_masters')->cascadeOnDelete();
            $table->string('field_key');
            $table->longText('field_value')->nullable();
            $table->unsignedInteger('group_index')->default(0);
            $table->timestamps();

            $table->unique(['kyc_link', 'kyc_section_id', 'kyc_field_master_id', 'group_index'], 'informations_unique');
            $table->index(['kyc_link', 'kyc_section_id'], 'informations_kyc_section_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informations');
    }
};
