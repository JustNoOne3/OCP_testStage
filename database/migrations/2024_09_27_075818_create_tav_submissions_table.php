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
        Schema::create('tav_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('tavSubmit_type')->nullable();
            $table->string('tavSubmit_file')->nullable();
            $table->string('tavSubmit_status')->nullable();
            $table->string('tavSubmit_region')->nullable();
            $table->string('tavSubmit_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tav_submissions');
    }
};
