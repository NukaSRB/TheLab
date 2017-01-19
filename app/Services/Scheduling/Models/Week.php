<?php

namespace App\Services\Scheduling\Models;

use Carbon\Carbon;

class Week
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $weekOfYear;

    /*
     * \JumpGate\Database\Collection
     */
    public $dailyTotal;

    /**
     * @var \JumpGate\Database\Collection|\App\Services\Scheduling\Models\Day
     */
    public $days;

    /**
     * Day constructor.
     *
     * @param \Carbon\Carbon   $week
     * @param \App\Models\User $user
     */
    public function __construct(Carbon $week, $user)
    {
        $this->dailyTotal = collector();

        $startOfWeek = $week->copy()->startOfWeek();
        $endOfWeek   = $startOfWeek->copy()->addDays(4);

        $firstDay = $startOfWeek->format('j');
        $lastDay  = $endOfWeek->format('j');
        $month    = $week->copy()->format('M');

        $this->name       = $firstDay . ' - ' . $lastDay . ' ' . $month;
        $this->weekOfYear = $week->weekOfYear;

        $days = collector();

        while ($startOfWeek->format('Y-m-d') <= $endOfWeek->format('Y-m-d')) {
            $data = new Day($startOfWeek, $user);

            $this->dailyTotal->put($startOfWeek->format('Y-m-d'), $data->schedule->sum('hours'));

            $days->add($data);

            $startOfWeek = $startOfWeek->addDay();
        }

        $this->days = $days;
    }
}
