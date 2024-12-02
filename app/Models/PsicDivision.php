<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsicDivision extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'division_name',
        'division_code',
    ];
}
