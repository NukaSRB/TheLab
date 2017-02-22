<?php

namespace App\Services\Scheduling\Models;

use App\Models\User;
use Carbon\Carbon;

class Month
{
    /**
     * @var \Carbon\Carbon
     */
    public $date;

    /**
     * @var \Carbon\Carbon
     */
    public $thisWeek;

    /**
     * @var \Carbon\Carbon
     */
    public $lastWeek;

    /**
     * @var \JumpGate\Database\Collection|\App\Services\Scheduling\Models\Week
     */
    public $weeks;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Month constructor.
     *
     * @param \App\Models\User $user
     * @param string           $date
     */
    public function __construct(User $user = null, $date = null)
    {
        $carbonDate = Carbon::now();

        if (! is_null($date)) {
            $carbonDate = Carbon::parse($date);
        }

        if ($carbonDate->isWeekend()) {
            $carbonDate = Carbon::parse('next Monday');
        }

        $this->user = $user;

        $this->date = $carbonDate;
        $this->getWeeks();
        $this->getCalendarWeeks();
    }

    protected function getWeeks()
    {
        $this->thisWeek = $this->date->copy()->startOfWeek();
        $this->lastWeek = $this->date->copy()->addWeeks(3)->endOfWeek();
    }

    protected function getCalendarWeeks()
    {
        $week     = $this->thisWeek->copy();
        $lastWeek = $this->lastWeek->copy();

        $weeks = collector();

        while ($week->weekOfYear <= $lastWeek->weekOfYear) {
            $data = new Week($week, $this->user);

            $weeks->add($data);

            $week->addWeek();
        }

        $this->weeks = $weeks->keyBy('weekOfYear');
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
