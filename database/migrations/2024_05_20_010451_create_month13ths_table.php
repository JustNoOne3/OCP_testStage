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
        Schema::create('month13ths', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->integer('month13th_yearCovered');
            $table->integer('month13th_numWorkers');
            $table->integer('month13th_amount');

            $table->string('month13th_ownRep');
            $table->string('month13th_designation');
            $table->string('month13th_contact');
            
            $table->integer('month13th_lessFive');
            $table->integer('month13th_fiveTen');
            $table->integer('month13th_tenTwenty');
            $table->integer('month13th_twentyThirty');
            $table->integer('month13th_thirtyForty');
            $table->integer('month13th_fortyFifty');
            $table->integer('month13th_fiftySixty');
            $table->integer('month13th_sixtySeventy');
            $table->integer('month13th_seventyEighty');
            $table->integer('month13th_eightyNinety');
            $table->integer('month13th_ninetyHundred');
            $table->integer('month13th_moreHundred');

            $table->string('month13th_estabId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('month13ths');
    }
};
