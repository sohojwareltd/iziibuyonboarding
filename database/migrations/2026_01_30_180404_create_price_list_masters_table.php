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
        Schema::create('price_list_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['merchant-selling', 'acquirer-cost', 'partner-kickback']);
            $table->string('currency', 3);
            $table->enum('status', ['active', 'draft', 'inactive'])->default('active');
            $table->enum('assignment_level', ['global', 'country', 'solution', 'acquirer', 'merchant'])->default('global');
            $table->json('assignment_rules')->nullable();
            $table->json('price_lines')->nullable();
            $table->string('version', 10)->default('1.0');
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('status');
            $table->index('currency');
            $table->index('assignment_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_list_masters');
    }
};
