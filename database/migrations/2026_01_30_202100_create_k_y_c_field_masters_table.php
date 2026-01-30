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
        Schema::create('k_y_c_field_masters', function (Blueprint $table) {
            $table->id();
            $table->string('field_name')->unique();
            $table->string('internal_key')->unique();
            $table->enum('kyc_section', ['beneficial', 'company', 'board', 'contact']);
            $table->text('description')->nullable();
            $table->enum('data_type', ['text', 'date', 'number', 'email', 'tel', 'file', 'dropdown', 'textarea']);
            $table->boolean('is_required')->default(false);
            $table->enum('sensitivity_level', ['normal', 'sensitive', 'highly-sensitive'])->default('normal');
            $table->boolean('visible_to_merchant')->default(true);
            $table->boolean('visible_to_admin')->default(true);
            $table->boolean('visible_to_partner')->default(false);
            $table->integer('sort_order')->default(100);
            $table->enum('status', ['active', 'draft', 'inactive'])->default('active');
            $table->timestamps();
            
            // Indices for common queries
            $table->index('kyc_section');
            $table->index('data_type');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_y_c_field_masters');
    }
};
