<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('informations', function (Blueprint $table) {
            $table->foreignId('onboarding_id')->nullable()->after('id')->constrained('onboardings')->cascadeOnDelete();
        });

        DB::statement('UPDATE informations i INNER JOIN onboardings o ON o.kyc_link = i.kyc_link SET i.onboarding_id = o.id');

        Schema::table('informations', function (Blueprint $table) {
            $table->dropUnique('informations_unique');
            $table->dropIndex('informations_kyc_section_idx');

            $table->unique(['onboarding_id', 'kyc_section_id', 'kyc_field_master_id', 'group_index'], 'informations_onboarding_unique');
            $table->index(['onboarding_id', 'kyc_section_id'], 'informations_onboarding_section_idx');
            $table->dropColumn('kyc_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informations', function (Blueprint $table) {
            $table->string('kyc_link')->nullable()->after('id');
        });

        DB::statement('UPDATE informations i INNER JOIN onboardings o ON o.id = i.onboarding_id SET i.kyc_link = o.kyc_link');

        Schema::table('informations', function (Blueprint $table) {
            $table->dropUnique('informations_onboarding_unique');
            $table->dropIndex('informations_onboarding_section_idx');

            $table->unique(['kyc_link', 'kyc_section_id', 'kyc_field_master_id', 'group_index'], 'informations_unique');
            $table->index(['kyc_link', 'kyc_section_id'], 'informations_kyc_section_idx');

            $table->dropConstrainedForeignId('onboarding_id');
            $table->dropColumn('onboarding_id');
        });
    }
};
