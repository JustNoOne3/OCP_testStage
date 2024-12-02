<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeleReportHead extends Model
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
         'teleHead_estabId',
         'teleHead_manageMale',
         'teleHead_manageFemale',
         'teleHead_superMale',
         'teleHead_superFemale',
         'teleHead_rankMale',
         'teleHead_rankFemale',
         'teleHead_total',

         'teleHead_disabMale',
         'teleHead_disabFemale',
         'teleHead_soloperMale',
         'teleHead_soloperFemale',
         'teleHead_immunoMale',
         'teleHead_immunoFemale',
         'teleHead_mentalMale',
         'teleHead_mentalFemale',
         'teleHead_seniorMale',
         'teleHead_seniorFemale',
         'teleHead_specialTotal',

         'teleHead_workspace',
         'teleHead_workspace_others',
         'teleHead_areasCovered',
         'teleHead_areasCovered_others',

         'teleHead_program',
         'teleHead_employer',
         'teleHead_designation',
         'teleHead_contact',
     ];

   protected $casts = [
      'teleHead_workspace' => 'array',
      'teleHead_areasCovered' => 'array',
   ];
}
