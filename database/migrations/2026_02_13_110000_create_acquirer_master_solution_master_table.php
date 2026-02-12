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
        Schema::create('acquirer_master_solution_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acquirer_master_id')->constrained('acquirer_masters')->onDelete('cascade');
            $table->foreignId('solution_master_id')->constrained('solution_masters')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['acquirer_master_id', 'solution_master_id'], 'acq_solution_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acquirer_master_solution_master');
    }
};
