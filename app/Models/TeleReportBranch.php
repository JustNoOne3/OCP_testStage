<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeleReportBranch extends Model
{
    use HasFactory;

    
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

     protected $fillable = [
        'id',
         'teleBranch_estabId',

         'teleBranch_manageMale',
         'teleBranch_manageFemale',
         'teleBranch_superMale',
         'teleBranch_superFemale',
         'teleBranch_rankMale',
         'teleBranch_rankFemale',
         'teleBranch_total',

         'teleBranch_disabMale',
         'teleBranch_disabFemale',
         'teleBranch_soloperMale',
         'teleBranch_soloperFemale',
         'teleBranch_immunoMale',
         'teleBranch_immunoFemale',
         'teleBranch_mentalMale',
         'teleBranch_mentalFemale',
         'teleBranch_seniorMale',
         'teleBranch_seniorFemale',
         'teleBranch_specialTotal',

         'teleBranch_workspace',
         'teleBranch_workspace_others',
         'teleBranch_areasCovered',
         'teleBranch_areasCovered_others',

         'teleBranch_program',
         'teleBranch_employer',
         'teleBranch_designation',
         'teleBranch_contact',

         
     ];

     protected $casts = [
      'teleBranch_workspace' => 'array',
      'teleBranch_areasCovered' => 'array',
   ];
}
