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
        Schema::create('onboardings', function (Blueprint $table) {
            $table->id();
            
            // Section 1: Core Configuration
            $table->foreignId('solution_id')->constrained('solution_masters')->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->cascadeOnDelete();
            $table->foreignId('merchant_user_id')->nullable()->constrained('users')->cascadeOnDelete();
            
            // Section 2: Merchant Details
            $table->string('legal_business_name');
            $table->string('trading_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('business_website')->nullable();
            $table->string('merchant_contact_email')->unique();
            $table->string('merchant_phone_number')->nullable();
            
            // Section 3: Operations & Acquirers
            $table->string('country_of_operation');
            $table->json('payment_methods')->nullable(); // JSON array: ['visa', 'mastercard', 'apple-pay', 'google-pay']
            $table->json('acquirers')->nullable(); // JSON array: ['elavon', 'surfboard']
            
            // Section 4: Pricing & Fees
            $table->foreignId('price_list_id')->nullable()->constrained('price_list_masters')->cascadeOnDelete();
            $table->json('custom_pricing')->nullable(); // JSON object for customized pricing
            
            // Section 5: Internal Tags & Notes
            $table->json('internal_tags')->nullable(); // JSON array of tags
            $table->longText('internal_notes')->nullable();
            
            // Section 6: System Information
            $table->string('request_id')->unique();
            $table->enum('status', ['draft', 'sent', 'in-review', 'approved', 'rejected', 'active', 'suspended'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            // Section 7: KYC Link
            $table->string('kyc_link')->nullable()->unique();
            $table->timestamp('kyc_completed_at')->nullable();
            
            // Additional Tracking
            $table->longText('rejection_reason')->nullable();
            $table->integer('revision_count')->default(0);
            
            $table->timestamps();
            
            // Indices
            $table->index('status');
            $table->index('created_by');
            $table->index('country_of_operation');
            $table->index('merchant_contact_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboardings');
    }
};
