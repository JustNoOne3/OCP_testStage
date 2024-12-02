<?php

namespace App\Observers;

use App\Models\Mtprf;

class MtprfObserver
{
    /**
     * Handle the Mtprf "created" event.
     */
    public function created(Mtprf $mtprf): void
    {
        //
    }

    public function creating(Mtprf $mtprf): void
    {
        
        $mtprf->id = session()->get('mtprf');
    }

    /**
     * Handle the Mtprf "updated" event.
     */
    public function updated(Mtprf $mtprf): void
    {
        //
    }

    /**
     * Handle the Mtprf "deleted" event.
     */
    public function deleted(Mtprf $mtprf): void
    {
        //
    }

    /**
     * Handle the Mtprf "restored" event.
     */
    public function restored(Mtprf $mtprf): void
    {
        //
    }

    /**
     * Handle the Mtprf "force deleted" event.
     */
    public function forceDeleted(Mtprf $mtprf): void
    {
        //
    }
}
