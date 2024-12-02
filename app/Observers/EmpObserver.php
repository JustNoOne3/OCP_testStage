<?php

namespace App\Observers;

use App\Models\Employees;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class EmpObserver
{
    /**
     * Handle the Employees "created" event.
     */
    public function created(Employees $employees): void
    {
        //
    }
    
    public function creating(Employees $employees): void
    {
        if(true){
            $uuid = Uuid::uuid4()->toString();
            $microseconds = substr(explode('.', microtime(true))[1], 0, 6); // Limit microseconds to 6 digits
            $uuid = 'emp-' . substr($uuid, 0, 12) . '-' . $microseconds;
            $employees->id = $uuid;
            $employees->emp_estabId = Auth::user()->est_id;
        }
    }
    /**
     * Handle the Employees "updated" event.
     */
    public function updated(Employees $employees): void
    {
        //
    }

    /**
     * Handle the Employees "deleted" event.
     */
    public function deleted(Employees $employees): void
    {
        //
    }

    /**
     * Handle the Employees "restored" event.
     */
    public function restored(Employees $employees): void
    {
        //
    }

    /**
     * Handle the Employees "force deleted" event.
     */
    public function forceDeleted(Employees $employees): void
    {
        //
    }
}
