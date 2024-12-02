<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsicGroup extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'group_name',
        'group_code',
    ];
}
