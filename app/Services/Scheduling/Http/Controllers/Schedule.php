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

        $dates = $this->getDays($date);

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

                return [
                    $date => [
                        'id'     => is_null($hours) ? null : $hours->id,
                        'hours'  => is_null($hours) ? null : $hours->hours,
                        'note'   => is_null($hours) ? null : $hours->note,
                        'repeat' => is_null($hours) ? null : $hours->repeat,
                    ],
                ];
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
                        $existingSchedule = $this->scheduledHours->find($details['id']);

                        // If we have a schedule but there are now no hours set, remove it.
                        if ($existingSchedule && $details['hours'] === '') {
                            $existingSchedule->delete();

                            return true;
                        }

                        if ($details['hours'] === '') {
                            return true;
                        }

                        $update = [
                            'user_id'    => (int)$userId,
                            'project_id' => $projectId,
                            'date'       => $date,
                        ];

                        $create = [
                            'user_id'    => (int)$userId,
                            'project_id' => $projectId,
                            'date'       => $date,
                            'hours'      => (int)$details['hours'],
                            'note'       => $details['note'] == '' ? null : $details['note'],
                            'repeat'     => isset($details['repeat']) ? Carbon::parse($date)->dayOfWeek : null,
                        ];

                        $this->scheduledHours->updateOrCreate($update, $create);
                    });
            });

        return redirect(route('admin.schedule.index'))
            ->with('message', 'Schedule updated.');
    }

    public function getProject($id, $date)
    {
        $project = $this->projects->with('client')->find($id);

        $scheduledHour          = new ScheduledHour(['hours' => null, 'note' => null, 'repeat' => null]);
        $scheduledHour->project = $project;

        $dates = $this->getDays($date);

        $schedule = [
            $id => $dates->mapWithKeys(function ($date) use ($scheduledHour) {
                return [$date['long'] => $scheduledHour];
            }),
        ];

        $form = [
            $id => $dates->mapWithKeys(function ($date) {
                return [$date['long'] => [
                    'id'     => null,
                    'hours'  => null,
                    'note'   => null,
                    'repeat' => null,
                ]];
            }),
        ];

        return response()->json(compact('schedule', 'form'));
    }

    /**
     * @param $date
     *
     * @return array|\Illuminate\Support\Collection
     */
    private function getDays($date)
    {
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

        return $dates;
    }
}
