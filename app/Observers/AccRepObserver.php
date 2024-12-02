<?php

namespace App\Observers;

use App\Models\AccidentReport;
use App\Models\Wair;

use Filament\Forms;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class AccRepObserver
{
    /**
     * Handle the AccidenReport "created" event.
     */
    public function created(AccidentReport $accidentReport): void
    {
        //
    }

    public function creating(AccidentReport $accidentReport): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'acc-' . substr($uuid, 0, 12) . '-' . $microseconds;

        $accidentReport->id = $uuid;
        $accidentReport->ar_affectedWorkers = session()->get('selected');
        $accidentReport->ar_affectedWorkers_count = session()->get('selected_count');
        $accidentReport->ar_estabId = Auth::user()->est_id;

        $wair = Wair::create(
            [
                'wairs_reportId' => $uuid,
                'wairs_reportType' => 'Accident Report',
                'wairs_estabId' => Auth::user()->est_id,
            ]
        );
    }


    /**
     * Handle the AccidenReport "updated" event.
     */
    public function updated(AccidentReport $accidentReport): void
    {
        //
    }

    /**
     * Handle the AccidenReport "deleted" event.
     */
    public function deleted(AccidentReport $accidentReport): void
    {
        //
    }

    /**
     * Handle the AccidenReport "restored" event.
     */
    public function restored(AccidentReport $accidentReport): void
    {
        //
    }

    /**
     * Handle the AccidenReport "force deleted" event.
     */
    public function forceDeleted(AccidentReport $accidentReport): void
    {
        //
    }
}
