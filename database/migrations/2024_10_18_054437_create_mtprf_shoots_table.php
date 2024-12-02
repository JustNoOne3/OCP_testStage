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
        Schema::create('mtprf_shoots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('mtprf_id')->nullable();
            $table->string('shoot_address')->nullable();
            $table->string('shoot_map')->nullable();
            // $table->json('shoot_startDate')->nullable();
            // $table->json('shoot_startTime')->nullable();
            // $table->json('shoot_endDate')->nullable();
            // $table->json('shoot_endtime')->nullable();
            // $table->json('shoot_workHoursMinor_date')->nullable();
            // $table->json('shoot_workHoursMinor_startTime')->nullable();
            // $table->json('shoot_workHoursMinor_endTime')->nullable();
            // $table->json('shoot_cancel_date')->nullable();
            // $table->json('shoot_cancel_reason')->nullable();
            // $table->json('shoot_cancel_affected')->nullable();
            // $table->json('shoot_cancel_commenced')->nullable();
            // $table->json('shoot_cancel_notice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtprf_shoots');
    }
};
