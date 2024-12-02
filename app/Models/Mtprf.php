<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MtprfShoot;
use App\Models\MtprfContractor;
use App\Models\MtprfCancel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mtprf extends Model
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
        'mtprf_companyName',
        'mtprf_companyType',
        'mtprf_director',
        'mtprf_address',

        'mtprf_representativeOwner',
        'mtprf_email',
        'mtprf_number',

        'mtprf_movieName',
        'mtprf_productionManager',
        'mtprf_pmEmail',
        'mtprf_pmContactNum',
        'mtprf_projectDuration',
        'mtprf_numDays',

        'mtprf_15male',
        'mtprf_15female',
        'mtprf_18male',
        'mtprf_18female',
        'mtprf_19male',
        'mtprf_19female',
        'mtprf_60male',
        'mtprf_60female',
        'mtprf_total',
        'mtprf_childPermit',
        'mtprf_contractorWorker',
        'mtprf_independentContractor',

        'mtprf_safetyOfficer',
        'mtprf_safetyOfficer_contact',
        'mtprf_firstAide',
        'mtprf_firstAide_contact',
        'mtprf_safeHealthCommittee',
        'mtprf_safeHealthCommittee_contact',
        'mtprf_hospitalMoa',
        'mtprf_hospitalMoa_contact',

        'mtprf_safetyProgram',
        'mtprf_permits',
        'mtprf_riskClass',
        'mtprf_firearms',
        'mtprf_actionPlan',
        'mtprf_animalHandling',
        'mtprf_emergencyTransport',
        'mtprf_others',

        'mtprf_decorumCommitee',
        'mtprf_representative',
        'mtprf_representativeAgent',
        'mtprf_representativeSupervisor',
        'mtprf_representativeRankFile',

        'mtprf_policy_harrassment',
        'mtprf_policy_mentalHealth',
        'mtprf_remarks',

        'mtprf_gbv_affectedTotal',
        'mtprf_gbv_affectedMale',
        'mtprf_gbv_affectedFemale',
        'mtprf_gbv_affectedLgbtq',
        'mtprf_gbv_offenderTotal',
        'mtprf_gbv_offenderMale',
        'mtprf_gbv_offenderFemale',
        'mtprf_gbv_offenderLgbtq',

        'mtprf_preparedBy',
        'mtprf_designation',
        'mtprf_submissionDate',

        'mtprf_shootDetails',

        'mtprfShoot',
        'mtprfCancel',
        'mtprfContract',
        'mtprf_workHours',
        'shoot_map',

    ];

    public function mtprfShoot(): HasMany
    {
        return $this->hasMany(MtprfShoot::class);
    }

    public function mtprfContract(): HasMany
    { 
        return $this->hasMany(MtprfContractor::class);
    }

    public function mtprfCancel(): HasMany
    { 
        return $this->hasMany(MtprfCancel::class);
    }

    protected $casts = [
        'mtprf_shootDetails' => 'array',
        'mtprfShoot' => 'array',
        'mtprfCancel' => 'array',
        'mtprfContract' => 'array',
        'mtprf_workHours' => 'array',
        'shoot_map' => 'array',
    ];
}
