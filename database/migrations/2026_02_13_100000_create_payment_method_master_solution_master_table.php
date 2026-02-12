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
        Schema::create('pm_master_solution_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_master_id')->constrained('payment_method_masters')->onDelete('cascade');
            $table->foreignId('solution_master_id')->constrained('solution_masters')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['payment_method_master_id', 'solution_master_id'], 'pm_solution_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pm_master_solution_master');
    }
};
