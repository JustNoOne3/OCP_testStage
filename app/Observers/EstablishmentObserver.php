<?php

namespace App\Observers;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Filament\Notifications\Notification;

class EstablishmentObserver
{
    /**
     * Handle the Establishment "created" event.
     */
    public function created(Establishment $establishment): void
    {
        //
    }

    public function creating(Establishment $establishment): void
    {
        
        $timestampInMilliseconds = microtime(true) * 100;
        $rand1 = intval(microtime(true) * 321);
        $rand2 = intval(microtime(true) * 82);
        $region = intval($establishment->region_id)/100000000;
        if($region<10){
            $region = '0'.$region;
            $city = substr($establishment->city_id, 1);
        }else{
            $city = substr($establishment->city_id, 2);
        }

        $city = substr($city, 0, 03);
        $dataId = 'R'.$region.'-'.$city.'-'.$rand2;

        $establishment->est_regId = $dataId;
        $establishment->est_id = $rand1;
        $establishment->est_status = "unvalidated";
        $establishment->est_acknowledgement = now()->format('Y-m-d');
        $establishment->est_certIssuance = now()->format('Y-m-d');
        $establishment->est_numworkTotal = $establishment->est_numworkMale + $establishment->est_numworkFemale;

        $user = User::query()->where('id', Auth::user()->id)->first();
        $user->est_id = $rand1; 
        $user->save();
        
        Notification::make()
            ->title("Congratulations! You have Successfully Registered your Establishment.")
            ->body("Your Establishment ID is " . $dataId . " .")
            ->icon('heroicon-o-building-office-2')
            ->iconColor('success')
            ->persistent()
            ->success()
            ->send();
        
        
    }

    /**
     * Handle the Establishment "updated" event.
     */
    public function updated(Establishment $establishment): void
    {
        //
    }

    /**
     * Handle the Establishment "deleted" event.
     */
    public function deleted(Establishment $establishment): void
    {
        //
    }

    public function deleting(Establishment $establishment): void
    {
        $user = User::query()->where('est_id', $establishment->est_id)->first();
        $user->est_id = null;
        $user->save();
    }

    /**
     * Handle the Establishment "restored" event.
     */
    public function restored(Establishment $establishment): void
    {
        //
    }

    /**
     * Handle the Establishment "force deleted" event.
     */
    public function forceDeleted(Establishment $establishment): void
    {
        //
    }
}
