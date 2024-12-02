<?php

namespace App\Observers;

use App\Models\NIAReport;
use App\Models\Wair;
use Filament\Forms;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class NoAccIllObserver
{
    /**
     * Handle the NIAReport "created" event.
     */
    public function created(NIAReport $nIAReport): void
    {
        //
    }

    public function creating(NIAReport $nIAReport): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'ill-' . substr($uuid, 0, 12) . '-' . $microseconds;

        $nIAReport->id = $uuid;
        $nIAReport->nia_estabId = Auth::user()->est_id;
        
        $wair = Wair::create(
            [
                'wairs_reportId' => $uuid,
                'wairs_reportType' => 'No Incident of Illness or Accident Report',
                'wairs_estabId' => Auth::user()->est_id,
            ]
        );
    }

    /**
     * Handle the NIAReport "updated" event.
     */
    public function updated(NIAReport $nIAReport): void
    {
        //
    }

    /**
     * Handle the NIAReport "deleted" event.
     */
    public function deleted(NIAReport $nIAReport): void
    {
        //
    }

    /**
     * Handle the NIAReport "restored" event.
     */
    public function restored(NIAReport $nIAReport): void
    {
        //
    }

    /**
     * Handle the NIAReport "force deleted" event.
     */
    public function forceDeleted(NIAReport $nIAReport): void
    {
        //
    }
}
