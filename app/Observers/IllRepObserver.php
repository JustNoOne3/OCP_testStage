<?php

namespace App\Observers;

use App\Models\IllnessReport;
use App\Models\Wair;
use Filament\Forms;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class IllRepObserver
{
    /**
     * Handle the IllnessReport "created" event.
     */
    public function created(IllnessReport $illnessReport): void
    {
        //
    }

    public function creating(IllnessReport $illnessReport): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'ill-' . substr($uuid, 0, 12) . '-' . $microseconds;

        $illnessReport->id = $uuid;
        $illnessReport->ip_affectedWorkers = session()->get('selected');
        $illnessReport->ip_affectedWorkers_count = session()->get('selected_count');
        $illnessReport->ip_estabId = Auth::user()->est_id;

        $wair = Wair::create(
            [
                'wairs_reportId' => $uuid,
                'wairs_reportType' => 'Illness Report',
                'wairs_estabId' => Auth::user()->est_id,
            ]
        );
    }

    /**
     * Handle the IllnessReport "updated" event.
     */
    public function updated(IllnessReport $illnessReport): void
    {
        //
    }

    /**
     * Handle the IllnessReport "deleted" event.
     */
    public function deleted(IllnessReport $illnessReport): void
    {
        //
    }

    /**
     * Handle the IllnessReport "restored" event.
     */
    public function restored(IllnessReport $illnessReport): void
    {
        //
    }

    /**
     * Handle the IllnessReport "force deleted" event.
     */
    public function forceDeleted(IllnessReport $illnessReport): void
    {
        //
    }
}
