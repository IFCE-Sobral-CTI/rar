<?php

namespace App\Observers;

use App\Mail\CreateRequirementMail;
use App\Models\Requirement;
use Illuminate\Support\Facades\Mail;

class RequirementObserver
{
    /**
     * Handle the Requirement "created" event.
     */
    public function created(Requirement $requirement): void
    {
        Mail::to($requirement->enrollment->student->personal_email)
            ->cc($requirement->enrollment->student->institucional_email)
            ->send(new CreateRequirementMail($requirement));
    }

    /**
     * Handle the Requirement "updated" event.
     */
    public function updated(Requirement $requirement): void
    {
        //
    }

    /**
     * Handle the Requirement "deleted" event.
     */
    public function deleted(Requirement $requirement): void
    {
        //
    }

    /**
     * Handle the Requirement "restored" event.
     */
    public function restored(Requirement $requirement): void
    {
        //
    }

    /**
     * Handle the Requirement "force deleted" event.
     */
    public function forceDeleted(Requirement $requirement): void
    {
        //
    }
}
