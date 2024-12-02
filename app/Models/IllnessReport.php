<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IllnessReport extends Model
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
        'ip_owner',
        'ip_nationality',
        'ip_engineering',
        'ip_engineering_cost',
        'ip_administrative',
        'ip_administrative_cost',
        'ip_ppe',
        'ip_ppe_cost',
        'ip_safetyOfficer',
        'ip_safetyOfficer_id',
        'ip_employer',
        'ip_employer_id',
        'ip_affectedWorkers',
        'ip_affectedWorkers_count',

        'ip_estabId',
    ];

    protected $casts = [
        'ip_affectedWorkers' => 'array',
    ];
}
