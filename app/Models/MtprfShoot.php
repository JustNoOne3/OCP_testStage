<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Mtprf;
use App\Models\MtprfWorkHours;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MtprfShoot extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'mtprf_id',
        'shoot_address',
        'shoot_map',
    ];

    public function MtprfWorkHours(): HasMany
    {
        return $this->hasMany(MtprfWorkHours::class);
    }

    protected $casts = [
        'mtprf_shootDetails' => 'array',
    ];
}
