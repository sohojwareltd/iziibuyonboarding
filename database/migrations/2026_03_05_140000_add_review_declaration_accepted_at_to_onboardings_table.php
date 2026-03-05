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
            $table->timestamp('review_declaration_accepted_at')->nullable()->after('kyc_completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onboardings', function (Blueprint $table) {
            $table->dropColumn('review_declaration_accepted_at');
        });
    }
};
