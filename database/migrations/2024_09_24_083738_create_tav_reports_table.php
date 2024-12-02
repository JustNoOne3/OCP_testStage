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
        Schema::create('tav_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tav_reportName')->nullable();
            $table->string('tav_reportUpload')->nullable();
            $table->string('tav_category')->nullable();
            $table->string('tav_region');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tav_reports');
    }
};
