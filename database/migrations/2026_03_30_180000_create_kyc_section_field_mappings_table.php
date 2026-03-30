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
        Schema::create('kyc_section_field_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kyc_section_id')->constrained('kyc_sections')->cascadeOnDelete();
            $table->foreignId('field_id')->constrained('k_y_c_field_masters')->cascadeOnDelete();
            $table->integer('sort_order')->default(100);
            $table->timestamps();

            $table->unique(['kyc_section_id', 'field_id']);
            $table->index(['kyc_section_id', 'sort_order']);
        });

        // Seed initial mapping from legacy one-to-many relation.
        DB::table('k_y_c_field_masters')
            ->select(['id', 'kyc_section_id', 'sort_order'])
            ->whereNotNull('kyc_section_id')
            ->orderBy('kyc_section_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                $payload = [];
                $now = now();

                foreach ($rows as $row) {
                    $payload[] = [
                        'kyc_section_id' => $row->kyc_section_id,
                        'field_id' => $row->id,
                        'sort_order' => $row->sort_order ?? 100,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if (!empty($payload)) {
                    DB::table('kyc_section_field_mappings')->insert($payload);
                }
            }, 'id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_section_field_mappings');
    }
};
