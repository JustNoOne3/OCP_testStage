<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Mtprf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MtprfCancel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'mtprf_id',
        'cancel_date',
        'cancel_reason',
        'cancel_affected',
        'cancel_commenced',
        'cancel_notice',
    ];

    // public function Mtprf(): BelongsTo
    // {
    //     return $this->belongsTo(Mtprf::class);
    // }
}
