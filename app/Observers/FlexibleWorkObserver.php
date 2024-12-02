<?php

namespace App\Observers;

use App\Models\FlexibleWork;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class FlexibleWorkObserver
{
    /**
     * Handle the FlexibleWork "created" event.
     */
    public function created(FlexibleWork $flexibleWork): void
    {
        //
    }
    
    public function creating(FlexibleWork $flexibleWork): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'flexiwork-' . substr($uuid, 0, 7) . '-' . $microseconds;

        $flexibleWork->id = $uuid;
        $flexibleWork->fwa_affectedWorkers = session()->get('selected');
        $flexibleWork->fwa_estabId = Auth::user()->est_id;
    }

    /**
     * Handle the FlexibleWork "updated" event.
     */
    public function updated(FlexibleWork $flexibleWork): void
    {
        //
    }

    /**
     * Handle the FlexibleWork "deleted" event.
     */
    public function deleted(FlexibleWork $flexibleWork): void
    {
        //
    }

    /**
     * Handle the FlexibleWork "restored" event.
     */
    public function restored(FlexibleWork $flexibleWork): void
    {
        //
    }

    /**
     * Handle the FlexibleWork "force deleted" event.
     */
    public function forceDeleted(FlexibleWork $flexibleWork): void
    {
        //
    }
}
