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
        Schema::create('establishments', function (Blueprint $table) {
            $table->id('est_id');
            $table->string('est_regId')->nullable();
            $table->string('est_name')->unique();
            $table->string('est_street');
            $table->bigInteger('region_id')->nullable();
            $table->string('province_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('barangay_id')->nullable();
            $table->string('psic_section')->nullable();
            $table->string('psic_division')->nullable();
            $table->string('psic_group')->nullable();
            $table->string('psic_class')->nullable();
            $table->string('est_products');
            $table->string('est_class');
            $table->string('est_tin');
            $table->string('est_sss');
            $table->string('est_payment');
            $table->string('est_yearImplemented');
            $table->integer('est_numworkMale');
            $table->integer('est_numworkFemale');
            $table->integer('est_numworkManager');
            $table->integer('est_numworkSupervisor');
            $table->integer('est_numworkRanks');
            $table->integer('est_numworkTotal');
            $table->string('est_permit')->nullable();
            $table->string('est_govId')->nullable();
            $table->string('est_owner');
            $table->string('est_designation');
            $table->string('est_telNum')->nullable();
            $table->string('est_contactNum');
            $table->string('est_email');
            $table->string('est_status')->nullable();
            $table->date('est_acknowledgement')->nullable();
            $table->date('est_certIssuance')->nullable();
            $table->string('est_authority')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};
