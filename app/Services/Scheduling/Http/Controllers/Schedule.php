<?php

namespace App\Services\Scheduling\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\Clients\Models\Project;
use App\Services\Scheduling\Models\Month;
use App\Services\Scheduling\Models\ScheduledHour;
use Carbon\Carbon;

class Schedule extends BaseController
{
    /**
     * @var \App\Models\User
     */
    private $users;

    /**
     * @var \App\Services\Scheduling\Models\ScheduledHour
     */
    private $scheduledHours;

    /**
     * @var \App\Services\Clients\Models\Project
     */
    private $projects;

    /**
     * Schedule constructor.
     *
     * @param \App\Models\User                              $users
     * @param \App\Services\Scheduling\Models\ScheduledHour $scheduledHours
     * @param \App\Services\Clients\Models\Project          $projects
     */
    public function __construct(User $users, ScheduledHour $scheduledHours, Project $projects)
    {
        $this->users          = $users;
        $this->scheduledHours = $scheduledHours;
        $this->projects       = $projects;
    }

    public function edit($userId, $date)
    {
        $user = $this->users->find($userId);

        $startDate = Carbon::parse($date);
        $endDate   = $startDate->copy()->addDays(4);

        $dates = collector();
        $date  = $startDate->copy();

        while ($date <= $endDate) {
            $dates[] = [
                'short' => $date->format('d M'),
                'long'  => $date->format('Y-m-d'),
                'class' => $date->format('Ymd'),
            ];

            $date = $date->copy()->addDay();
        }

        $mysqlDates = $dates->flatMap(function ($date) {
            return [$date['long']];
        });

        $schedules = $this->scheduledHours
            ->with('project.client')
            ->where('user_id', $userId)
            ->whereIn('date', $mysqlDates->toArray())
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('project_id')
            ->transform(function ($schedule) {
                return $schedule->keyBy(function ($date) {
                    return $date->date->format('Y-m-d');
                });
            });

        $projects = $this->projects
            ->with('client')
            ->whereNotIn('id', $schedules->keys()->toArray())
            ->orderByNameAsc()
            ->get();

        $form = $schedules->map(function ($schedule, $projectId) use ($mysqlDates) {
            $data = collect($mysqlDates)->mapWithKeys(function ($date) use ($schedule) {
                $hours = $schedule->get($date);

                return [$date => is_null($hours) ? null : $hours->hours];
            });

            return $data;
        });

        $this->setJavascriptData(compact('user', 'projects', 'dates', 'schedules', 'form'));

        return view('admin.schedule.edit');
    }

    public function update($userId, $date)
    {
        collector(request()->get('hours'))
            ->each(function ($project, $projectId) use ($userId) {
                collector($project)
                    ->each(function ($details, $date) use ($userId, $projectId) {
                        if ($details['hours'] === '') {
                            return true;
                        }

                        $data = [
                            'user_id'    => $userId,
                            'project_id' => $projectId,
                            'date'       => $date,
                            'hours'      => $details['hours'],
                            'note'       => $details['note'],
                            'repeat'     => $details['repeat'],
                        ];

                        $this->scheduledHours->create($data);
                    });
            });
    }
}
