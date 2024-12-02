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
        Schema::create('mtprf_contractors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('mtprf_id')->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('contractor_service')->nullable();
            $table->string('contractor_address')->nullable();
            $table->string('contractor_mobileNum')->nullable();
            $table->string('contractor_regNum')->nullable();
            $table->string('contractor_deployedMale')->nullable();
            $table->string('contractor_deployedFemale')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtprf_contractors');
    }
};
