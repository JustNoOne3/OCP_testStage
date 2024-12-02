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
        Schema::create('li_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('liSubmit_type')->nullable();
            $table->string('liSubmit_file')->nullable();
            $table->string('liSubmit_status')->nullable();
            $table->string('liSubmit_region')->nullable();
            $table->string('liSubmit_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('li_submissions');
    }
};
