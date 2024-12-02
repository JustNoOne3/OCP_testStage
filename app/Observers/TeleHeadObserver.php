<?php

namespace App\Observers;

use App\Models\TeleReportHead;

use App\Models\TeleReport;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class TeleHeadObserver
{
    /**
     * Handle the TeleReportHead "created" event.
     */
    public function created(TeleReportHead $teleReportHead): void
    {
        //
    }

    public function creating(TeleReportHead $teleReportHead): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'head-' . substr($uuid, 0, 11) . '-' . $microseconds;

        $teleReportHead->id = $uuid;
        $teleReportHead->teleHead_estabId = Auth::user()->est_id;
        $teleReportHead->teleHead_total = $teleReportHead->teleHead_manageMale + $teleReportHead->teleHead_manageFemale + $teleReportHead->teleHead_superMale + $teleReportHead->teleHead_rankMale + $teleReportHead->teleHead_superFemale + $teleReportHead->teleHead_rankFemale;
        $teleReportHead->teleHead_specialTotal = 
            $teleReportHead->teleHead_disabMale + 
            $teleReportHead->teleHead_disabFemale +
            $teleReportHead->teleHead_soloperMale +
            $teleReportHead->teleHead_soloperFemale +
            $teleReportHead->teleHead_immunoMale +
            $teleReportHead->teleHead_immunoFemale +
            $teleReportHead->teleHead_mentalMale +
            $teleReportHead->teleHead_mentalFemale +
            $teleReportHead->teleHead_seniorMale +
            $teleReportHead->teleHead_seniorFemale;

        $wair = TeleReport::create(
            [
                'tele_reportId' => $uuid,
                'tele_reportType' => 'Head Office Report',
                'tele_estabId' => Auth::user()->est_id,
            ]
        );
    }

    /**
     * Handle the TeleReportHead "updated" event.
     */
    public function updated(TeleReportHead $teleReportHead): void
    {
        //
    }

    /**
     * Handle the TeleReportHead "deleted" event.
     */
    public function deleted(TeleReportHead $teleReportHead): void
    {
        //
    }

    /**
     * Handle the TeleReportHead "restored" event.
     */
    public function restored(TeleReportHead $teleReportHead): void
    {
        //
    }

    /**
     * Handle the TeleReportHead "force deleted" event.
     */
    public function forceDeleted(TeleReportHead $teleReportHead): void
    {
        //
    }
}
