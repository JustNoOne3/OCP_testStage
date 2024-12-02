<?php

namespace App\Observers;

use App\Models\TeleReportBranch;

use App\Models\TeleReport;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Illuminate\Support\Facades\Auth;

class TeleBranchObserver
{
    /**
     * Handle the TeleReportBranch "created" event.
     */
    public function created(TeleReportBranch $teleReportBranch): void
    {
        //
    }

    public function creating(TeleReportBranch $teleReportBranch): void
    {
        $uuid = Uuid::uuid4()->toString();
        $microseconds = substr(explode('.', microtime(true))[1], 0, 6);
        $uuid = 'teleBranch-' . substr($uuid, 0, 7) . '-' . $microseconds;

        $teleReportBranch->id = $uuid;
        $teleReportBranch->teleBranch_total = $teleReportBranch->teleBranch_manageMale + $teleReportBranch->teleBranch_manageFemale + $teleReportBranch->teleBranch_superMale + $teleReportBranch->teleBranch_rankMale + $teleReportBranch->teleBranch_superFemale + $teleReportBranch->teleBranch_rankFemale;
        $teleReportBranch->teleBranch_specialTotal = 
            $teleReportBranch->teleBranch_disabMale + 
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale +
            $teleReportBranch->teleBranch_disabFemale;

        $teleReportBranch->teleBranch_estabId = Auth::user()->est_id;
        $wair = TeleReport::create(
            [
                'tele_reportId' => $uuid,
                'tele_reportType' => 'Branch Report',
                'tele_estabId' => Auth::user()->est_id,
            ]
        );
    }

    /**
     * Handle the TeleReportBranch "updated" event.
     */
    public function updated(TeleReportBranch $teleReportBranch): void
    {
        //
    }

    /**
     * Handle the TeleReportBranch "deleted" event.
     */
    public function deleted(TeleReportBranch $teleReportBranch): void
    {
        //
    }

    /**
     * Handle the TeleReportBranch "restored" event.
     */
    public function restored(TeleReportBranch $teleReportBranch): void
    {
        //
    }

    /**
     * Handle the TeleReportBranch "force deleted" event.
     */
    public function forceDeleted(TeleReportBranch $teleReportBranch): void
    {
        //
    }
}
