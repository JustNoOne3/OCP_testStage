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
        Schema::create('tele_report_heads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('teleHead_estabId')->nullable();

            $table->string('teleHead_manageMale')->nullable();
            $table->integer('teleHead_manageFemale')->nullable();
            $table->integer('teleHead_superMale')->nullable();
            $table->integer( 'teleHead_superFemale')->nullable();
            $table->integer('teleHead_rankMale')->nullable();
            $table->integer('teleHead_rankFemale')->nullable();
            $table->integer('teleHead_total')->nullable();
            $table->integer('teleHead_disabMale')->nullable();
            $table->integer('teleHead_disabFemale')->nullable();
            $table->integer('teleHead_soloperMale')->nullable();
            $table->integer('teleHead_soloperFemale')->nullable();
            $table->integer('teleHead_immunoMale')->nullable();
            $table->integer('teleHead_immunoFemale')->nullable();
            $table->integer('teleHead_mentalMale')->nullable();
            $table->integer('teleHead_mentalFemale')->nullable();
            $table->integer('teleHead_seniorMale',)->nullable();
            $table->integer('teleHead_seniorFemale',)->nullable();
            $table->integer('teleHead_specialTotal')->nullable();
            $table->json('teleHead_workspace')->nullable();
            $table->string('teleHead_workspace_others')->nullable();
            $table->json('teleHead_areasCovered')->nullable();
            $table->string('teleHead_areasCovered_others')->nullable();
            $table->string('teleHead_program')->nullable();
            $table->string('teleHead_employer')->nullable();
            $table->string('teleHead_designation')->nullable();
            $table->string('teleHead_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tele_report_heads');
    }
};
