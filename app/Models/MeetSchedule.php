<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'meet_estabId',
        'meet_estEmail',
        'meet_date',
        'meet_time', 
    ];
}
