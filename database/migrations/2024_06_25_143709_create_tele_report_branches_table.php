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
        Schema::create('tele_report_branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('teleBranch_estabId')->nullable();

            $table->string('teleBranch_manageMale')->nullable();
            $table->integer('teleBranch_manageFemale')->nullable();
            $table->integer('teleBranch_superMale')->nullable();
            $table->integer( 'teleBranch_superFemale')->nullable();
            $table->integer('teleBranch_rankMale')->nullable();
            $table->integer('teleBranch_rankFemale')->nullable();
            $table->integer('teleBranch_total')->nullable();
            $table->integer('teleBranch_disabMale')->nullable();
            $table->integer('teleBranch_disabFemale')->nullable();
            $table->integer('teleBranch_soloperMale')->nullable();
            $table->integer('teleBranch_soloperFemale')->nullable();
            $table->integer('teleBranch_immunoMale')->nullable();
            $table->integer('teleBranch_immunoFemale')->nullable();
            $table->integer('teleBranch_mentalMale')->nullable();
            $table->integer('teleBranch_mentalFemale')->nullable();
            $table->integer('teleBranch_seniorMale',)->nullable();
            $table->integer('teleBranch_seniorFemale',)->nullable();
            $table->integer('teleBranch_specialTotal')->nullable();
            $table->json('teleBranch_workspace')->nullable();
            $table->string('teleBranch_workspace_others')->nullable();
            $table->json('teleBranch_areasCovered')->nullable();
            $table->string('teleBranch_areasCovered_others')->nullable();
            $table->string('teleBranch_program')->nullable();
            $table->string('teleBranch_employer')->nullable();
            $table->string('teleBranch_designation')->nullable();
            $table->string('teleBranch_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tele_report_branches');
    }
};
