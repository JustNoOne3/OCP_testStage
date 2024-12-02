<?php

namespace App\Observers;

use App\Models\Month13th;
use Illuminate\Support\Facades\Auth;
use Filament\Panel;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Month13thObserver
{
    /**
     * Handle the Month13th "created" event.
     */
    public function created(Month13th $month13th): void
    {
        //
    }

    public function creating(Month13th $month13th): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'month13th-' . substr($uuid, 0, 7) . '-' . $microseconds;
        
        $month13th->id = $uuid;
        $month13th->month13th_estabId = Auth::user()->est_id;
        // session()->put('month13thId', $month13th->id);
    }

    /**
     * Handle the Month13th "updated" event.
     */
    public function updated(Month13th $month13th): void
    {
        //
    }

    /**
     * Handle the Month13th "deleted" event.
     */
    public function deleted(Month13th $month13th): void
    {
        //
    }

    /**
     * Handle the Month13th "restored" event.
     */
    public function restored(Month13th $month13th): void
    {
        //
    }

    /**
     * Handle the Month13th "force deleted" event.
     */
    public function forceDeleted(Month13th $month13th): void
    {
        //
    }
}
