<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'nationality',
        'country',
    ];
}
