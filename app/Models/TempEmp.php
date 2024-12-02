<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempEmp extends Model
{
    use HasFactory;

    ////////////////////////////////////////////////////// required for UUID prinmary key //////////////////////////////
    /**
     * The primary key associated with the table.
     *
     * @var string
     */

     /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */

     protected $primaryKey = 'id';
     public $incrementing = false;
     protected $keyType = 'string';
     
    ////////////////////////////////////////////////////// required for UUID prinmary key //////////////////////////////


    protected $fillable = [
        'id',
        'emp_estabId',
        'emp_lastName',
        'emp_firstName',
        'emp_middleName',
        'emp_extensionName',
        'emp_birthday',
        'emp_sex',
        'emp_civilStatus',
        'emp_houseNum',
        'emp_street',
        'emp_region',
        'emp_province',
        'emp_city',
        'emp_barangay',
        'emp_wage',
        'emp_numDependents',
        'emp_serviceLength',
        'emp_occupation',
        'emp_yearsExp',
        'emp_employmentStatus',
        'emp_shiftStart',
        'emp_shiftEnd',
        'emp_workHours',
        'emp_workDays',
    ];

}
