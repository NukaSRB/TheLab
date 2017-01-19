<?php

namespace App\Services\Scheduling\Models;

use Carbon\Carbon;

class Day
{
    /**
     * @var string
     */
    public $day;

    /**
     * @var string
     */
    public $date;

    /**
     * @var \JumpGate\Database\Collection|\App\Services\Scheduling\Models\ScheduledHour
     */
    public $schedule;

    /**
     * Day constructor.
     *
     * @param \Carbon\Carbon   $day
     * @param \App\Models\User $user
     */
    public function __construct(Carbon $day, $user)
    {
        $this->day      = $day->format('d');
        $this->date     = $day->format('Y-m-d');
        $this->schedule = collector();

        if (! is_null($user)) {
            $this->schedule = ScheduledHour::getHoursForDate($day, $user->id);
        }
    }
}
