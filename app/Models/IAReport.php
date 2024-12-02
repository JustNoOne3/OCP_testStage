<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IAReport extends Model
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
        'ia_owner',
        'ia_nationality',
        'ia_dateTime',
        'ia_injury',
        'ia_damage',
        'ia_description',
        'ia_wasInjured',
        'ia_ntInjuredReason',
        'ia_agencyInvolved',
        'ia_agencyPart',
        'ia_accidentType',
        'ia_condition',
        'ia_unsafeAct',
        'ia_factor',
        'ia_preventiveMeasure',
        'ia_safeguard',
        'ia_useSafeguard',
        'ia_ntSafeguardReason',
        'ia_affectedWorkers',
        'ia_affectedWorkers_count',
        'ia_compensation',
        'ia_compensation_amount',
        'ia_medical',
        'ia_burial',
        'ia_timeLostDay',
        'ia_timeLostDay_hours',
        'ia_timeLostDay_mins',
        'ia_timeLostSubseq',
        'ia_timeLostSubseq_hours',
        'ia_timeLostSubseq_mins',
        'ia_timeReducedOutput',
        'ia_timeReducedOutput_days',
        'ia_timeReducedOutput_percent',
        'ia_machineryDamage',
        'ia_machineryDamage_repair',
        'ia_machineryDamage_time', 
        'ia_machineryDamage_production',
        'ia_materialDamage',
        'ia_materialDamage_repair',
        'ia_materialDamage_time',
        'ia_materialDamage_production',
        'ia_equipmentDamage',
        'ia_equipmentDamage_repair',
        'ia_equipmentDamage_time',
        'ia_equipmentDamage_production',
        'ia_safetyOfficer',
        'ia_safetyOfficer_id',
        'ia_employer',
        'ia_employer_id',

        'ia_estabId'
    ];

    protected $casts = [
        'ia_affectedWorkers' => 'array',
    ];
}
