<?php

namespace App\Observers;

use App\Models\IAReport;
use App\Models\Wair;
use Filament\Forms;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;


class AccIllObserver
{
    /**
     * Handle the IAReport "created" event.
     */
    public function created(IAReport $iAReport): void
    {
        //
    }

    public function creating(IAReport $iAReport): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'ai-' . substr($uuid, 0, 12) . '-' . $microseconds;

        $iAReport->id = $uuid;
        $iAReport->ia_affectedWorkers = session()->get('selected');
        $iAReport->ia_affectedWorkers_count = session()->get('selected_count');
        $iAReport->ia_estabId = Auth::user()->est_id;

        $wair = Wair::create(
            [
                'wairs_reportId' => $uuid,
                'wairs_reportType' => 'Accident and Illness Report',
                'wairs_estabId' => Auth::user()->est_id,
            ]
        );
    }
    /**
     * Handle the IAReport "updated" event.
     */
    public function updated(IAReport $iAReport): void
    {
        //
    }

    /**
     * Handle the IAReport "deleted" event.
     */
    public function deleted(IAReport $iAReport): void
    {
        //
    }

    /**
     * Handle the IAReport "restored" event.
     */
    public function restored(IAReport $iAReport): void
    {
        //
    }

    /**
     * Handle the IAReport "force deleted" event.
     */
    public function forceDeleted(IAReport $iAReport): void
    {
        //
    }
}
