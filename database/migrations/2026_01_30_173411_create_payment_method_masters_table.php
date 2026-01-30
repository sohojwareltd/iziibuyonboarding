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
        Schema::create('payment_method_masters', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('name')->unique();
            $table->string('display_label');
            $table->enum('category', ['card', 'wallet', 'bank'])->default('card');
            $table->text('description')->nullable();
            
            // Supported Countries (JSON array)
            $table->json('supported_countries')->nullable();
            
            // Supported Acquirers (JSON array with structure: [{id: 1, types: ['online', 'pos', 'recurring']}])
            $table->json('supported_acquirers')->nullable();
            
            // Supported Solutions (JSON array of solution IDs)
            $table->json('supported_solutions')->nullable();
            
            // Payment Method Details
            $table->string('scheme')->nullable(); // visa, mastercard, amex, etc.
            $table->boolean('supports_3ds')->default(false);
            $table->boolean('allows_tokenization')->default(false);
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            
            // Compliance Tags
            $table->boolean('requires_additional_documents')->default(false);
            $table->boolean('requires_acquirer_configuration')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index('category');
            $table->index('is_active');
            $table->index('scheme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_masters');
    }
};
