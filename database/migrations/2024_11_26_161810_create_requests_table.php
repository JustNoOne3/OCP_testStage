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
        Schema::create('requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('req_reportId')->nullable();
            $table->string('req_reportType')->nullable();
            $table->string('req_estabId')->nullable();
            $table->string('req_estabName')->nullable();
            $table->string('req_region')->nullable();
            $table->string('req_field')->nullable();
            $table->string('req_fieldNew')->nullable();
            $table->string('req_reason')->nullable();
            $table->string('req_status')->nullable();
            $table->string('req_resolution')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
