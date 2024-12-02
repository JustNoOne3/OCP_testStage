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
        Schema::create('temp_emps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('emp_estabId');
            $table->timestamps();
            $table->string('emp_lastName')->nullable();
            $table->string('emp_firstName')->nullable();
            $table->string('emp_middleName')->nullable();
            $table->string('emp_extensionName')->nullable();
            $table->string('emp_birthday')->nullable();
            $table->string('emp_sex')->nullable();
            $table->string('emp_civilStatus')->nullable();
            $table->string('emp_houseNum')->nullable();
            $table->string('emp_street')->nullable();
            $table->string('emp_region')->nullable();
            $table->string('emp_province')->nullable();
            $table->string('emp_city')->nullable();
            $table->string('emp_barangay')->nullable();
            $table->string('emp_wage')->nullable();
            $table->string('emp_numDependents')->nullable();
            $table->string('emp_serviceLength')->nullable();
            $table->string('emp_occupation')->nullable();
            $table->string('emp_yearsExp')->nullable();
            $table->string('emp_employmentStatus')->nullable();
            $table->string('emp_shiftStart')->nullable();
            $table->string('emp_shiftEnd')->nullable();
            $table->string('emp_workHours')->nullable();
            $table->string('emp_workDays')->nullable();

            $table->string('emp_injill')->nullable();

            $table->string('emp_injNature')->nullable();
            $table->string('emp_injAffected')->nullable();

            $table->string('emp_illType')->nullable();
            $table->string('emp_illLocation')->nullable();
            
            $table->string('emp_dateStart')->nullable();
            $table->string('emp_dateReturned')->nullable();
            $table->string('emp_daysLost')->nullable();
            $table->string('emp_daysCharged')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_emps');
    }
};
