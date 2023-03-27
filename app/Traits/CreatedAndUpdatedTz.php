<?php

namespace App\Traits;

use Carbon\Carbon;

trait CreatedAndUpdatedTz
{
    /**
     * Returns the date in the defined timezone
     */
    public function getCreatedAtAttribute(string $date): string
    {
        return Carbon::parse($date)->setTimezone(env('APP_TIMEZONE', 'UTC'))->format('d/m/Y H:i:s');
    }

    /**
     * Returns the date in the defined timezone
     */
    public function getUpdatedAtAttribute(string $date): string
    {
        return Carbon::parse($date)->setTimezone(env('APP_TIMEZONE', 'UTC'))->format('d/m/Y H:i:s');
    }
}
