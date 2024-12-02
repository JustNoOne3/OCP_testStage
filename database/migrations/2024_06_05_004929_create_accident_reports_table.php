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
        Schema::create('accident_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('ar_owner');
            $table->string('ar_nationality');
            $table->string('ar_dateTime');
            $table->string('ar_injury');
            $table->string('ar_damage');
            $table->string('ar_description')->maxLength(500);
            $table->string('ar_wasInjured');
            $table->string('ar_ntInjuredReason')->nullable();
            $table->string('ar_agencyInvolved');
            $table->string('ar_agencyPart');
            $table->string('ar_accidentType');
            $table->string('ar_condition');
            $table->string('ar_unsafeAct');
            $table->string('ar_factor');
            $table->string('ar_preventiveMeasure');
            $table->string('ar_safeguard');
            $table->string('ar_useSafeguard');
            $table->string('ar_ntSafeguardReason')->nullable();
            $table->string('ar_engineer');
            $table->string('ar_engineer_cost');
            $table->string('ar_administrative');
            $table->string('ar_administrative_cost');
            $table->string('ar_ppe');
            $table->string('ar_ppe_cost');
            $table->json('ar_affectedWorkers')->nullable();
            $table->integer('ar_affectedWorkers_count');
            $table->string('ar_compensation');
            $table->string('ar_compensation_amount');
            $table->string('ar_medical');
            $table->string('ar_burial');
            $table->string('ar_timeLostDay');
            $table->string('ar_timeLostDay_hours');
            $table->string('ar_timeLostDay_mins');
            $table->string('ar_timeLostSubseq');
            $table->string('ar_timeLostSubseq_hours');
            $table->string('ar_timeLostSubseq_mins');
            $table->string('ar_timeReducedOutput');
            $table->string('ar_timeReducedOutput_days');
            $table->string('ar_timeReducedOutput_percent');
            $table->string('ar_machineryDamage');
            $table->string('ar_machineryDamage_repair');
            $table->string('ar_machineryDamage_time');
            $table->string('ar_machineryDamage_production');
            $table->string('ar_materialDamage');
            $table->string('ar_materialDamage_repair');
            $table->string('ar_materialDamage_time');
            $table->string('ar_materialDamage_production');
            $table->string('ar_equipmentDamage');
            $table->string('ar_equipmentDamage_repair');
            $table->string('ar_equipmentDamage_time');
            $table->string('ar_equipmentDamage_production');
            $table->string('ar_safetyOfficer');
            $table->string('ar_safetyOfficer_id')->nullable();
            $table->string('ar_employer');
            $table->string('ar_employer_id')->nullable();

            $table->string('ar_estabId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accident_reports');
    }
};
