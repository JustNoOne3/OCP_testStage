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
        Schema::create('mtprf_work_hours', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('mtprf_id')->nullable();
            $table->string('shoots_id')->nullable();
            $table->string('shoot_address')->nullable();
            $table->string('shoot_map')->nullable();
            $table->string('shoot_startDate')->nullable();
            $table->string('shoot_startTime')->nullable();
            $table->string('shoot_endDate')->nullable();
            $table->string('shoot_endtime')->nullable();
            $table->string('shoot_workHoursMinor_date')->nullable();
            $table->string('shoot_workHoursMinor_startTime')->nullable();
            $table->string('shoot_workHoursMinor_endTime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtprf_work_hours');
    }
};
