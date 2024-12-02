<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsicClass extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'class_name',
        'class_code',
    ];
}
