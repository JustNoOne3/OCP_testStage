<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LiReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'li_reportName',
        'li_reportUpload',
        'li_category',
        'li_region',
    ];
}
