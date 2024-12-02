<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TavSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'tavSubmit_type',
        'tavSubmit_file',
        'tavSubmit_status',
        'tavSubmit_region',
        'tavSubmit_user',
    ];
}
