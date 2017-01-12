<?php

namespace App\Services\Scheduling\Commands;

use App\Services\Scheduling\Models\ScheduledHour;
use App\Services\Scheduling\Transformers\Schedule;
use App\Services\Timing\Commands\Summary;
use App\Services\Timing\Commands\Timer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ScheduleDetails
{
    /**
     * @var \App\Services\Scheduling\Models\ScheduledHour
     */
    private $scheduledHour;

    /**
     * @var \JumpGate\Database\Collection
     */
    private $dailySummary;

    /**
     * @var \JumpGate\Database\Collection
     */
    private $weeklySummary;

    /**
     * @var array
     */
    private $timer;

    /**
     * @var \JumpGate\Database\Collection
     */
    private $schedules;

    /**
     * ScheduleDetails constructor.
     *
     * @param \App\Services\Scheduling\Models\ScheduledHour $scheduledHour
     */
    public function __construct(ScheduledHour $scheduledHour)
    {
        $this->scheduledHour = $scheduledHour;
    }

    public function __invoke()
    {
        list($this->dailySummary, $this->weeklySummary) = command(Summary::class);

        $this->timer     = command(Timer::class, null);
        $this->schedules = $this->getSchedules();

        $dailySchedule  = $this->getDailySchedules();
        $weeklySchedule = $this->getWeeklySchedules();

        return [
            $dailySchedule,
            $weeklySchedule,
        ];
    }

    private function getSchedules()
    {
        return $this->scheduledHour->with('project.client')
                                   ->where('user_id', auth()->id())
                                   ->where('date', '>=', Carbon::now()->startOfWeek()->startOfDay())
                                   ->where('date', '<=', Carbon::now()->endOfWeek()->endOfDay())
                                   ->get();
    }

    private function getDailySchedules()
    {
        return $this->schedules->getWhere('date', Carbon::now()->startOfDay())
                               ->transform(function ($scheduled) {
                                   return $this->transformSchedule($scheduled, $this->dailySummary);
                               })
                               ->sortBy('client.name')
                               ->values();
    }

    private function getWeeklySchedules()
    {
        return $this->schedules->groupBy('project_id')
                               ->transform(function ($scheduled) {
                                   return $this->transformSchedule($scheduled, $this->weeklySummary);
                               })
                               ->sortBy('client.name')
                               ->values();
    }

    private function transformSchedule($scheduled, $summary)
    {
        // If there are multiple entries per client, consolidate into one entry.
        if ($scheduled instanceof Collection) {
            $hours            = $scheduled->sum('hours');
            $scheduled        = $scheduled->first();
            $scheduled->hours = $hours;
        }

        $scheduled->time = 0;

        if ($summary->has($scheduled->project->client->label)) {
            $scheduled->time = $summary->get($scheduled->project->client->label)['decimal'];
        }

        if (! is_null($this->timer) && $this->timer['client']['id'] === (int)$scheduled->project->client->toggl_id) {
            $duration        = time() + $this->timer['duration'];
            $scheduled->time = $scheduled->time + (decimalHours(convertMicroSecondsArray($duration)));
        }

        return Schedule::transform($scheduled);
    }
}
