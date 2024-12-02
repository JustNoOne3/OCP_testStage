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
        Schema::create('i_a_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            //
            $table->string('ia_owner')->nullable();
            $table->string('ia_nationality')->nullable();
            //
            $table->string('ia_dateTime')->nullable();
            $table->string('ia_injury')->nullable();
            $table->string('ia_damage')->nullable();
            $table->string('ia_description')->nullable();
            $table->string('ia_wasInjured')->nullable();
            $table->string('ia_ntInjuredReason')->nullable();
            $table->string('ia_agencyInvolved')->nullable();
            $table->string('ia_agencyPart')->nullable();
            $table->string('ia_accidentType')->nullable();
            $table->string('ia_condition')->nullable();
            $table->string('ia_unsafeAct')->nullable();
            $table->string('ia_factor')->nullable();
            //
            $table->string('ia_preventiveMeasure')->nullable();
            $table->string('ia_safeguard')->nullable();
            $table->string('ia_useSafeguard')->nullable();
            $table->string('ia_ntSafeguardReason')->nullable();
            //
            $table->json('ia_affectedWorkers')->nullable();
            $table->integer('ia_affectedWorkers_count')->nullable();
            //
            $table->string('ia_compensation')->nullable();
            $table->string('ia_compensation_amount')->nullable();
            $table->string('ia_medical')->nullable();
            $table->string('ia_burial')->nullable();
            $table->string('ia_timeLostDay')->nullable();
            $table->string('ia_timeLostDay_hours')->nullable();
            $table->string('ia_timeLostDay_mins')->nullable();
            $table->string('ia_timeLostSubseq')->nullable();
            $table->string('ia_timeLostSubseq_hours')->nullable();
            $table->string('ia_timeLostSubseq_mins')->nullable();
            $table->string('ia_timeReducedOutput')->nullable();
            $table->string('ia_timeReducedOutput_days')->nullable();
            $table->string('ia_timeReducedOutput_percent')->nullable();
            //
            $table->string('ia_machineryDamage')->nullable();
            $table->string('ia_machineryDamage_repair')->nullable();
            $table->string('ia_machineryDamage_time')->nullable();
            $table->string('ia_machineryDamage_production')->nullable();
            $table->string('ia_materialDamage')->nullable();
            $table->string('ia_materialDamage_repair')->nullable();
            $table->string('ia_materialDamage_time')->nullable();
            $table->string('ia_materialDamage_production')->nullable();
            $table->string('ia_equipmentDamage')->nullable();
            $table->string('ia_equipmentDamage_repair')->nullable();
            $table->string('ia_equipmentDamage_time')->nullable();
            $table->string('ia_equipmentDamage_production')->nullable();
            //
            $table->string('ia_safetyOfficer')->nullable();
            $table->string('ia_safetyOfficer_id')->nullable();
            $table->string('ia_employer')->nullable();
            $table->string('ia_employer_id')->nullable();

            $table->string('ia_estabId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_a_reports');
    }
};
