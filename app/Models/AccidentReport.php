<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccidentReport extends Model
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
        'ar_owner',
        'ar_nationality',
        'ar_dateTime',
        'ar_injury',
        'ar_damage',
        'ar_description',
        'ar_wasInjured',
        'ar_ntInjuredReason',
        'ar_agencyInvolved',
        'ar_agencyPart',
        'ar_accidentType',
        'ar_condition',
        'ar_unsafeAct',
        'ar_factor',
        'ar_preventiveMeasure',
        'ar_safeguard',
        'ar_useSafeguard',
        'ar_ntSafeguardReason',
        'ar_engineer',
        'ar_engineer_cost',
        'ar_administrative',
        'ar_administrative_cost',
        'ar_ppe',
        'ar_ppe_cost',
        'ar_affectedWorkers',
        'ar_affectedWorkers_count',
        'ar_compensation',
        'ar_compensation_amount',
        'ar_medical',
        'ar_burial',
        'ar_timeLostDay',
        'ar_timeLostDay_hours',
        'ar_timeLostDay_mins',
        'ar_timeLostSubseq',
        'ar_timeLostSubseq_hours',
        'ar_timeLostSubseq_mins',
        'ar_timeReducedOutput',
        'ar_timeReducedOutput_days',
        'ar_timeReducedOutput_percent',
        'ar_machineryDamage',
        'ar_machineryDamage_repair',
        'ar_machineryDamage_time', 
        'ar_machineryDamage_production',
        'ar_materialDamage',
        'ar_materialDamage_repair',
        'ar_materialDamage_time',
        'ar_materialDamage_production',
        'ar_equipmentDamage',
        'ar_equipmentDamage_repair',
        'ar_equipmentDamage_time',
        'ar_equipmentDamage_production',
        'ar_safetyOfficer',
        'ar_safetyOfficer_id',
        'ar_employer',
        'ar_employer_id',

        'ar_estabId'
    ];

    protected $casts = [
        'ar_affectedWorkers' => 'array',
    ];
}
