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
        Schema::create('n_i_a_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('nia_owner');
            $table->string('nia_nationality');

            $table->string('nia_safetyOfficer');
            $table->string('nia_safetyOfficer_id');
            $table->string('nia_employer');
            $table->string('nia_employer_id');

            $table->string('nia_estabId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('n_i_a_reports');
    }
};
