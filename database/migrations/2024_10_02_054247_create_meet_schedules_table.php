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
        Schema::create('meet_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('meet_estabId');
            $table->string('meet_estEmail');
            $table->date('meet_date');
            $table->time('meet_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meet_schedules');
    }
};
