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
        Schema::create('document_types_masters', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('document_name')->unique();
            $table->enum('category', ['identity', 'company', 'bank']);
            $table->text('description')->nullable();

            // File Format & Size Rules
            $table->json('allowed_file_types'); // ['pdf', 'png', 'jpg', 'jpeg']
            $table->integer('max_file_size'); // in MB
            $table->integer('min_pages')->default(0)->nullable();

            // Visibility & Sensitivity Controls
            $table->enum('sensitivity_level', ['normal', 'sensitive', 'highly-sensitive']);
            $table->boolean('visible_to_merchant')->default(true);
            $table->boolean('visible_to_admin')->default(true);
            $table->boolean('mask_metadata')->default(false);

            // Required For (Dynamic Mapping)
            $table->json('required_acquirers')->nullable(); // ['elavon', 'surfboard', 'stripe']
            $table->json('required_countries')->nullable(); // ['uk', 'no', 'us']
            $table->json('required_solutions')->nullable(); // ['pos', 'ecommerce', 'mobile']
            $table->string('kyc_section')->nullable();

            // Status & Notes
            $table->enum('status', ['active', 'draft', 'inactive'])->default('active');
            $table->text('internal_notes')->nullable();

            $table->timestamps();

            // Indices
            $table->index('category');
            $table->index('status');
            $table->index('sensitivity_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types_masters');
    }
};
