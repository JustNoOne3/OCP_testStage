<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeleReport extends Model
{
    use HasFactory;

     protected $fillable = [
        'tele_reportType',
        'tele_reportId',
        'tele_estabId',
     ];
}
