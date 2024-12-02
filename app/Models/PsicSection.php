<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsicSection extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'section_name',
        'section_code',
    ];
}
