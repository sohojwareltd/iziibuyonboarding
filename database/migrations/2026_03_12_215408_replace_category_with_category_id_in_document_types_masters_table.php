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
        Schema::table('document_types_masters', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('document_name');
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });

        // Migrate existing slug-based data to category_id
        DB::table('document_types_masters')->get()->each(function ($row) {
            if ($row->category) {
                $cat = DB::table('categories')->where('slug', $row->category)->first();
                if ($cat) {
                    DB::table('document_types_masters')
                        ->where('id', $row->id)
                        ->update(['category_id' => $cat->id]);
                }
            }
        });

        Schema::table('document_types_masters', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_types_masters', function (Blueprint $table) {
            $table->string('category')->nullable()->after('document_name');
        });

        // Restore slug from category_id
        DB::table('document_types_masters')->get()->each(function ($row) {
            if ($row->category_id) {
                $cat = DB::table('categories')->where('id', $row->category_id)->first();
                if ($cat) {
                    DB::table('document_types_masters')
                        ->where('id', $row->id)
                        ->update(['category' => $cat->slug]);
                }
            }
        });

        Schema::table('document_types_masters', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
