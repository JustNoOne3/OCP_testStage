<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TavReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'tav_reportName',
        'tav_reportUpload',
        'tav_category',
        'tav_region',
    ];
}
