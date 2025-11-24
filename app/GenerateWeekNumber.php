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

        $isoYear = $carbonDate->isoWeekYear();
        $isoWeek = $carbonDate->isoWeek();


        $weekId = $isoYear . str_pad($isoWeek, 2, '0', STR_PAD_LEFT);

        return $weekId;
    }

    /**
     * Optionally, get the start and end dates of the ISO week.
     */
    public function weekRangeFromId(string $weekId): array
    {
        // Extract year (first 4 chars)
        $isoYear = substr($weekId, 0, 4);

        // Extract week number (last 2 chars)
        $isoWeek = substr($weekId, 4, 2);

        // Get the start of the ISO week
        $startOfWeek = Carbon::now()
            ->setISODate($isoYear, (int)$isoWeek)
            ->startOfWeek(Carbon::MONDAY);

        // End of the ISO week
        $endOfWeek = (clone $startOfWeek)->endOfWeek(Carbon::SUNDAY);

        return [
            'start' => $startOfWeek->toDateString(),
            'end'   => $endOfWeek->toDateString(),
        ];
    }

}

