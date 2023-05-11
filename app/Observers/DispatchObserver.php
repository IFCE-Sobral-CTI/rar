<?php

namespace App\Observers;

use App\Mail\CreateDispatchMail;
use App\Models\Dispatch;
use Illuminate\Support\Facades\Mail;

class DispatchObserver
{
    /**
     * Handle the Dispatch "created" event.
     */
    public function created(Dispatch $dispatch): void
    {
        Mail::to($dispatch->requirement->enrollment->student->personal_email)
            ->cc($dispatch->requirement->enrollment->student->institucional_email)
            ->send(new CreateDispatchMail($dispatch));
    }

    /**
     * Handle the Dispatch "updated" event.
     */
    public function updated(Dispatch $dispatch): void
    {
        //
    }

    /**
     * Handle the Dispatch "deleted" event.
     */
    public function deleted(Dispatch $dispatch): void
    {
        //
    }

    /**
     * Handle the Dispatch "restored" event.
     */
    public function restored(Dispatch $dispatch): void
    {
        //
    }

    /**
     * Handle the Dispatch "force deleted" event.
     */
    public function forceDeleted(Dispatch $dispatch): void
    {
        //
    }
}
