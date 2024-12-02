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
        Schema::create('li_reports', function (Blueprint $table) {
            $table->id();
            $table->string('li_reportName')->nullable();
            $table->string('li_reportUpload')->nullable();
            $table->string('li_category')->nullable();
            $table->string('li_region')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('li_reports');
    }
};
