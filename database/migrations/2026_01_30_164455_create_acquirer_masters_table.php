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
        Schema::create('acquirer_masters', function (Blueprint $table) {
            $table->id();
            
            // Acquirer Information
            $table->string('name')->unique(); // Acquirer Name
            $table->enum('mode', ['email', 'api'])->default('email'); // Mode
            $table->boolean('is_active')->default(true); // Status
            $table->text('description')->nullable(); // Description
            
            // Supported Countries (JSON)
            $table->json('supported_countries')->nullable();
            
            // Supported Solutions (JSON - IDs of solutions)
            $table->json('supported_solutions')->nullable();
            
            // Email Configuration
            $table->string('email_recipient')->nullable(); // Email Recipient(s)
            $table->string('email_subject_template')->nullable(); // Email Subject Template
            $table->text('email_body_template')->nullable(); // Email Body Template
            $table->enum('attachment_format', ['pdf', 'zip'])->default('pdf'); // Attachment Format
            $table->boolean('secure_email_required')->default(false); // Secure Email Required
            
            // Compliance Configuration
            $table->boolean('requires_beneficial_owner_data')->default(false); // Requires Beneficial Owner Data
            $table->boolean('requires_board_member_data')->default(false); // Requires Board Member Data
            $table->boolean('requires_signatories')->default(true); // Requires Signatories
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquirer_masters');
    }
};
