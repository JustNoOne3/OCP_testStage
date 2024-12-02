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
        Schema::create('mtprves', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('mtprf_companyName')->nullable();
            $table->string('mtprf_companyType')->nullable();
            $table->string('mtprf_director')->nullable();
            $table->string('mtprf_address')->nullable();

            $table->string('mtprf_representativeOwner')->nullable();
            $table->string('mtprf_email')->nullable();
            $table->string('mtprf_number')->nullable();

            $table->string('mtprf_movieName')->nullable();
            $table->string('mtprf_productionManager')->nullable();
            $table->string('mtprf_pmEmail')->nullable();
            $table->string('mtprf_pmContactNum')->nullable();
            $table->string('mtprf_projectDuration')->nullable();
            $table->string('mtprf_numDays')->nullable();

            $table->string('mtprf_15male')->nullable();
            $table->string('mtprf_15female')->nullable();
            $table->string(' mtprf_18male')->nullable();
            $table->string('mtprf_18female')->nullable();
            $table->string('mtprf_19male')->nullable();
            $table->string('mtprf_19female')->nullable();
            $table->string('mtprf_60male')->nullable();
            $table->string('mtprf_60female')->nullable();
            $table->string('mtprf_total')->nullable();
            $table->string('mtprf_childPermit')->nullable();
            $table->string('mtprf_contractorWorker')->nullable();
            $table->string('mtprf_independentContractor')->nullable();

            $table->string('mtprf_safetyOfficer')->nullable();
            $table->string('mtprf_safetyOfficer_contact')->nullable();
            $table->string('mtprf_firstAide')->nullable();
            $table->string('mtprf_firstAide_contact')->nullable();
            $table->string('mtprf_safeHealthCommittee')->nullable();
            $table->string('mtprf_safeHealthCommittee_contact')->nullable();
            $table->string('mtprf_hospitalMoa')->nullable();
            $table->string('mtprf_hospitalMoa_contact')->nullable();

             $table->string('mtprf_safetyProgram')->nullable();
             $table->string('mtprf_permits')->nullable();
             $table->string('mtprf_riskClass')->nullable();
             $table->string('mtprf_firearms')->nullable();
             $table->string('mtprf_actionPlan')->nullable();
             $table->string('mtprf_animalHandling')->nullable();
             $table->string('mtprf_emergencyTransport')->nullable();
             $table->string('mtprf_others')->nullable();

             $table->string('mtprf_decorumCommitee')->nullable();
             $table->string('mtprf_representative')->nullable();
             $table->string('mtprf_representativeAgent')->nullable();
             $table->string('mtprf_representativeSupervisor')->nullable();
             $table->string('mtprf_representativeRankFile')->nullable();

            $table->string('mtprf_policy_harrassment')->nullable();
            $table->string('mtprf_policy_mentalHealth')->nullable();
            $table->string('mtprf_remarks')->nullable();

            $table->string('mtprf_gbv_affectedTotal')->nullable();
            $table->string('mtprf_gbv_affectedMale')->nullable();
            $table->string('mtprf_gbv_affectedFemale')->nullable();
            $table->string('mtprf_gbv_affectedLgbtq')->nullable();
            $table->string('mtprf_gbv_offenderTotal')->nullable();
            $table->string('mtprf_gbv_offenderMale')->nullable();
            $table->string('mtprf_gbv_offenderFemale')->nullable();
            $table->string('mtprf_gbv_offenderLgbtq')->nullable();


            $table->string('mtprf_preparedBy')->nullable();
            $table->string('mtprf_designation')->nullable();
            $table->string('mtprf_submissionDate')->nullable();

            $table->string('mtprf_estabId')->nullable();
            $table->string('mtprf_region')->nullable();


            $table->json('mtprfShoot')->nullable();
            $table->json('mtprfCancel')->nullable();
            $table->json('mtprfContract')->nullable();
            $table->json('mtprf_workHours')->nullable();
            $table->json('shoot_map')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtprves');
    }
};
