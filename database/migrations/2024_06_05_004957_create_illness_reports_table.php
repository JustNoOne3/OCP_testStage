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
        Schema::create('illness_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('ip_owner');
            $table->string('ip_nationality');

            $table->string('ip_engineering');
            $table->string('ip_engineering_cost');
            $table->string('ip_administrative');
            $table->string('ip_administrative_cost');
            $table->string('ip_ppe');
            $table->string('ip_ppe_cost');

            $table->json('ip_affectedWorkers')->nullable();
            $table->integer('ip_affectedWorkers_count');

            $table->string('ip_safetyOfficer');
            $table->string('ip_safetyOfficer_id');
            $table->string('ip_employer');
            $table->string('ip_employer_id');

            $table->string('ip_estabId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('illness_reports');
    }
};
