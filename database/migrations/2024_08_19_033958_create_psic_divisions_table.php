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
        Schema::create('psic_divisions', function (Blueprint $table) {
            $table->integer('division_id')->primary();
            $table->timestamps();
            $table->string('division_name');
            $table->string('division_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psic_divisions');
    }
};
