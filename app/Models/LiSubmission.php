<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'liSubmit_type',
        'liSubmit_file',
        'liSubmit_status',
        'liSubmit_region',
        'liSubmit_user',
    ];
}
