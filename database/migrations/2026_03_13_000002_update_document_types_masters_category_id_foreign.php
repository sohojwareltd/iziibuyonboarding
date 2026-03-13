<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only drop the old FK if it still exists (may have been removed by a prior failed run)
        $hasFk = collect(DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'document_types_masters'
              AND CONSTRAINT_NAME = 'document_types_masters_category_id_foreign'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        "))->isNotEmpty();

        if ($hasFk) {
            Schema::table('document_types_masters', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });
        }

        // Existing category_id values reference the old categories table,
        // which has no matching rows in document_type_categories yet.
        // Null them out so the new FK constraint passes cleanly.
        DB::table('document_types_masters')->update(['category_id' => null]);

        Schema::table('document_types_masters', function (Blueprint $table) {
            // Re-point to the new document_type_categories table
            $table->foreign('category_id')
                ->references('id')
                ->on('document_type_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('document_types_masters', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
        });
    }
};
