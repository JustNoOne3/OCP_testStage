<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlexibleWork extends Model
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
        'fwa_estabId',
        'fwa_startDate',
        'fwa_endDate',
        'fwa_type',
        'fwa_typeSpecify',
        'fwa_reason',
        'fwa_reasonSpecify',
        'fwa_affectedWorkers',
        'fwa_agreement',
        'fwa_owner',
        'fwa_designation',
        'fwa_contact',
    ];

    protected $casts = [
        'fwa_affectedWorkers' => 'array',
    ];
}
