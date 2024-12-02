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
        Schema::create('flexible_work_temps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('fwa_startDate')->nullable();
            $table->date('fwa_endDate')->nullable();
            $table->string('fwa_type')->nullable();
            $table->string('fwa_typeSpecify')->nullable();
            $table->string('fwa_reason')->nullable();
            $table->string('fwa_reasonSpecify')->nullable();
            $table->json('fwa_affectedWorkers')->nullable();
            $table->string('fwa_estabId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flexible_work_temps');
    }
};
