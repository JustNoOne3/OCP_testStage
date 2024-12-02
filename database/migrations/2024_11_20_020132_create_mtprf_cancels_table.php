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
        Schema::create('mtprf_cancels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('mtprf_id')->nullable();
            $table->json('cancel_date')->nullable();
            $table->json('cancel_reason')->nullable();
            $table->json('cancel_affected')->nullable();
            $table->json('cancel_commenced')->nullable();
            $table->json('cancel_notice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtprf_cancels');
    }
};
