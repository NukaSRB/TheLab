<?php

namespace App\Services\Dashboards\Http\Controllers;

use App\Apis\Toggl\Client as TogglClient;
use App\Http\Controllers\BaseController;
use App\Services\Clients\Models\Task;
use App\Services\Dashboards\Transformers\Event;
use App\Services\Scheduling\Commands\ScheduleDetails;
use App\Services\Timing\Commands\Summary;
use App\Services\Timing\Commands\Timer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Production extends BaseController
{
    /**
     * @var \App\Apis\Toggl\Client
     */
    private $toggl;

    /**
     * Dev constructor.
     *
     * @param \App\Apis\Toggl\Client $toggl
     */
    public function __construct(TogglClient $toggl)
    {
        $this->toggl = $toggl;
    }

    public function __invoke()
    {
        $timeEntries = $this->toggl->setApiKey(auth()->user()->getProvider('toggl')->token)
                                   ->handle('GetTimeEntries');

        $previousTasks = \App\Services\Timing\Transformers\Timer::transformAll($timeEntries)
                                                                ->unique(function ($timer) {
                                                                    return $timer['pid'] . $timer['tid'] . $timer['description'];
                                                                })
                                                                ->sortByDesc('stop')
                                                                ->take(10)
                                                                ->values();

        $toggl  = auth()->user()->getProvider('toggl');
        $events = $this->getUserCalendarEvents()->chunk(4);
        $tasks  = $this->getAvailableTasks();

        $timer = command(Timer::class, null);
        list($dailySummary, $weeklySummary) = command(Summary::class);
        list($dailySchedule, $weeklySchedule) = command(ScheduleDetails::class);

        $this->setViewData(compact('events', 'dailySchedule', 'weeklySchedule', 'timer', 'dailySummary', 'weeklySummary'));
        $this->setJavascriptData(compact('previousTasks', 'toggl', 'tasks', 'events', 'dailySchedule', 'weeklySchedule', 'timer', 'dailySummary', 'weeklySummary'));

        return $this->view();
    }

    /**
     * @return mixed|null
     */
    private function getActiveTimer()
    {
        // todo - convert this to user's API key
        $timer = $this->toggl->setApiKey(env('A_TOGGL_KEY'))->handle('GetCurrentTimeEntry');

        if (array_key_exists('data', $timer)) {
            $timer = null;
        }

        if (! is_null($timer)) {
            $timer = Timer::transform($timer);
        }

        return $timer;
    }

    private function getSummary($duration = 'day')
    {
        $cacheKey = 'summary:' . auth()->id() . ':' . $duration;

        if (cache()->has($cacheKey)) {
            return cache($cacheKey);
        }

        switch ($duration) {
            case 'day':
                $since = Carbon::now()->startOfDay();
                break;
            case 'week':
                $since = Carbon::now()->startOfWeek();
                break;
        }

        $summary = $this->toggl
            ->handle('Summary', [
                'workspace_id' => (int)env('TOGGL_WORKSPACE_ID'),
                'since'        => $since,
                'until'        => Carbon::now(),
                'user_ids'     => auth()->user()->getProvider('toggl')->social_id,
            ]);

        $results = [];

        foreach ($summary['data'] as $timeSpent) {
            $time = convertMicroSecondsArray($timeSpent['time'] / 1000);

            $results[$timeSpent['title']['client']] = [
                'time'    => $time,
                'decimal' => decimalHours($time),
            ];
        }

        cache()->put($cacheKey, $results, 5);

        return $results;
    }

    private function getUserCalendarEvents()
    {
        $cacheKey = 'upcomingEvents:' . auth()->id();

        if (cache()->has($cacheKey)) {
            return cache($cacheKey);
        }

        $userGoogle = auth()->user()->getProvider('google');
        $token      = [
            'access_token'  => $userGoogle->token,
            'refresh_token' => $userGoogle->refresh_token,
            'expires_in'    => $userGoogle->expires_in,
        ];

        $google = new \Google_Client;
        $google->setClientId(env('GOOGLE_CLIENT_ID'));
        $google->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $google->setAccessToken($token);

        $service = new \Google_Service_Calendar($google);

        $events = $service->events->listEvents('primary', [
            'timeMin'      => Carbon::now()->startOfDay()->format('c'),
            'timeMax'      => Carbon::now()->endOfDay()->format('c'),
            'showDeleted'  => false,
            'singleEvents' => true,
            'orderBy'      => 'startTime',
        ]);

        $events = Event::transformAll($events->getItems());

        cache()->put($cacheKey, $events, 5);

        return $events;
    }

    /**
     * @param $timer
     * @param $dailySummary
     * @param $weeklySummary
     *
     * @return array
     */
    private function getSchedule($timer, $dailySummary, $weeklySummary)
    {
        $schedule = ScheduledHour::with('project.client')
                                 ->where('user_id', auth()->id())
                                 ->where('date', '>=', Carbon::now()->startOfWeek()->startOfDay())
                                 ->where('date', '<=', Carbon::now()->endOfWeek()->endOfDay())
                                 ->get();

        $dailySchedule = $schedule->getWhere('date', Carbon::now()->startOfDay())
                                  ->transform(function ($scheduled) use ($dailySummary, $timer) {
                                      return $this->transformSchedule($scheduled, $dailySummary, $timer);
                                  })
                                  ->sortBy('client.name')
                                  ->values();

        $weeklySchedule = $schedule->groupBy('project_id')
                                   ->transform(function ($scheduled) use ($weeklySummary, $timer) {
                                       return $this->transformSchedule($scheduled, $weeklySummary, $timer);
                                   })
                                   ->sortBy('client.name')
                                   ->values();

        return [$dailySchedule, $weeklySchedule];
    }

    protected function transformSchedule($scheduled, $summary, $timer)
    {
        // If there are multiple entries per client, consolidate into one entry.
        if ($scheduled instanceof Collection) {
            $hours            = $scheduled->sum('hours');
            $scheduled        = $scheduled->first();
            $scheduled->hours = $hours;
        }

        $scheduled->time = 0;

        if (array_key_exists($scheduled->project->client->label, $summary)) {
            $scheduled->time = $summary[$scheduled->project->client->label]['decimal'];
        }

        if (! is_null($timer) && $timer['client']['id'] === (int)$scheduled->project->client->toggl_id) {
            $duration        = time() + $timer['duration'];
            $scheduled->time = $scheduled->time + (decimalHours(convertMicroSecondsArray($duration)));
        }

        return Schedule::transform($scheduled);
    }

    /**
     * @return mixed
     */
    private function getAvailableTasks()
    {
        $tasks = Task::with('project.client')->orderByNameAsc()->get()->map(function ($task) {
            $names = [
                $task->project->client->label,
                $task->project->label,
                $task->label,
            ];

            return (object)[
                'id'   => $task->id,
                'name' => implode(' - ', $names),
            ];
        })->sortBy('name');

        return $tasks;
    }
}
