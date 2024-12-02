<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month13th extends Model
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
        'month13th_yearCovered',
        'month13th_numWorkers',
        'month13th_amount',
        'month13th_ownRep',
        'month13th_designation',
        'month13th_contact',
        'month13th_lessFive',
        'month13th_fiveTen',
        'month13th_tenTwenty',
        'month13th_twentyThirty',
        'month13th_thirtyForty',
        'month13th_fortyFifty',
        'month13th_fiftySixty',
        'month13th_sixtySeventy',
        'month13th_seventyEighty',
        'month13th_eightyNinety',
        'month13th_ninetyHundred',
        'month13th_moreHundred',
        'month13th_estabId',
    ];
}
