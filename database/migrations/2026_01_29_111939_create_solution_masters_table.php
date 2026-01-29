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
        Schema::create('solution_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->string('country')->nullable();
            $table->json('acquirers')->nullable();
            $table->json('payment_methods')->nullable();
            $table->json('alternative_methods')->nullable();
            $table->text('requirements')->nullable();
            $table->string('pricing_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solution_masters');
    }
};
