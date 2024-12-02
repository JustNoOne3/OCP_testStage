<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Mtprf;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MtprfContractor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'mtprf_id',
        'contractor_name',
        'contractor_service',
        'contractor_address',
        'contractor_mobileNum',
        'contractor_regNum',
        'contractor_deployedMale',
        'contractor_deployedFemale',
    ];

    // public function Mtprf(): BelongsTo
    // {
    //     return $this->belongsTo(Mtprf::class);
    // }
}
