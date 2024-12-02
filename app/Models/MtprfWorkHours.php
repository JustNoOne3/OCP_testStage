<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MtprfWorkHours extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'mtprf_id',
        'shoot_id',
        'shoot_address',
        'shoot_map',
        'shoot_startDate',
        'shoot_startTime',
        'shoot_endDate',
        'shoot_endtime',
        'shoot_workHoursMinor_date',
        'shoot_workHoursMinor_startTime',
        'shoot_workHoursMinor_endTime',
    ];
}
