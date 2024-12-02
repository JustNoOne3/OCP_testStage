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
        Schema::create('tele_report_temps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('teleBranch_estabId');

            $table->string('teleBranch_manageMale');
            $table->integer('teleBranch_manageFemale');
            $table->integer('teleBranch_superMale');
            $table->integer( 'teleBranch_superFemale');
            $table->integer('teleBranch_rankMale');
            $table->integer('teleBranch_rankFemale');
            $table->integer('teleBranch_total');
            $table->integer('teleBranch_disabMale');
            $table->integer('teleBranch_disabFemale');
            $table->integer('teleBranch_soloperMale');
            $table->integer('teleBranch_soloperFemale');
            $table->integer('teleBranch_immunoMale');
            $table->integer('teleBranch_immunoFemale');
            $table->integer('teleBranch_mentalMale');
            $table->integer('teleBranch_mentalFemale');
            $table->integer('teleBranch_seniorMale',);
            $table->integer('teleBranch_seniorFemale',);
            $table->integer('teleBranch_specialTotal');
            $table->json('teleBranch_workspace');
            $table->string('teleBranch_workspace_others')->nullable();
            $table->json('teleBranch_areasCovered');
            $table->string('teleBranch_areasCovered_others')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tele_report_temps');
    }
};
