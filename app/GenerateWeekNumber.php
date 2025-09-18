<?php

namespace App;

use Carbon\Carbon;

class GenerateWeekNumber
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // No initialization needed for this example
    }

    /**
     * Get a unique week ID for a given date.
     * Format: YYYYWW (ISO week year + 2-digit ISO week number)
     */
    public function weekId(string $date): string
    {
        $carbonDate = Carbon::parse($date);

        $isoYear = $carbonDate->isoWeekYear(); // ISO week-numbering year
        $isoWeek = $carbonDate->isoWeek();     // ISO week number

        // Ensure week is always 2 digits
        $weekId = $isoYear . str_pad($isoWeek, 2, '0', STR_PAD_LEFT);

        return $weekId;
    }

    /**
     * Optionally, get the start and end dates of the ISO week.
     */
    public function weekRange(string $date): array
    {
        $carbonDate = Carbon::parse($date);

        return [
            'start' => $carbonDate->startOfWeek(Carbon::MONDAY)->toDateString(),
            'end' => $carbonDate->endOfWeek(Carbon::SUNDAY)->toDateString(),
        ];
    }
}

