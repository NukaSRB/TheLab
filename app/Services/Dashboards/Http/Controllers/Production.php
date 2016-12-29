<?php

namespace App\Services\Dashboards\Http\Controllers;

use App\Apis\Toggl\Client as TogglClient;
use App\Http\Controllers\BaseController;
use App\Services\Scheduling\Models\ScheduledHour;
use Carbon\Carbon;

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
        $timer         = $this->getActiveTimer();
        $dailySummary  = $this->getSummary('day');
        $weeklySummary = $this->getSummary('week');

        $dailySchedule = ScheduledHour::where('user_id', auth()->id())
                                      ->where('date', date('Y-m-d'))
                                      ->get()
                                      ->transform(function ($scheduled) use ($dailySummary, $timer) {
                                          return $this->transformSchedule($scheduled, $dailySummary, $timer);
                                      });

        $weeklySchedule = ScheduledHour::where('user_id', auth()->id())
                                       ->where('date', '>=', Carbon::now()->startOfWeek()->startOfDay())
                                       ->where('date', '<=', Carbon::now()->endOfWeek()->endOfDay())
                                       ->get()
                                       ->transform(function ($scheduled) use ($weeklySummary, $timer) {
                                           return $this->transformSchedule($scheduled, $weeklySummary, $timer);
                                       });

        $this->setViewData(compact('dailySchedule', 'weeklySchedule', 'timer', 'dailySummary', 'weeklySummary'));

        return $this->view();
    }

    /**
     * @return mixed|null
     */
    private function getActiveTimer()
    {
        // todo - convert this to user's API key
        $timer = $this->toggl->setApiKey('7cc984f789e75be10f47762f8144643c')->handle('GetCurrentTimeEntry');

        if (array_key_exists('data', $timer)) {
            $timer = null;
        }

        if (! is_null($timer)) {
            $timer['project'] = $this->toggl->handle('GetProject', ['id' => $timer['pid']]);
            $timer['client']  = $this->toggl->handle('GetClient', ['id' => $timer['project']['cid']]);
            $timer['task']    = $this->toggl->handle('GetTask', ['id' => $timer['tid']]);
        }

        return $timer;
    }

    private function getSummary($duration = 'day')
    {
        if (cache()->has('summary:' . $duration)) {
            return cache('summary:' . $duration);
        }

        switch ($duration) {
            case 'day':
                $since = Carbon::now()->startOfDay();
                break;
            case 'week':
                $since = Carbon::now()->startOfWeek();
                break;
        }

        // todo - convert this to a user's actual toggl id
        $summary = $this->toggl
            ->handle('Summary', [
                'workspace_id' => (int)env('TOGGL_WORKSPACE_ID'),
                'since'        => $since,
                'until'        => Carbon::now(),
                'user_ids'     => 1777547, // Travis
                // 'user_ids'     => 1296913, // David
            ]);

        $results = [];

        foreach ($summary['data'] as $timeSpent) {
            $time = convertMicroSecondsArray($timeSpent['time'] / 1000);

            $results[$timeSpent['title']['client']] = [
                'time'    => $time,
                'decimal' => decimalHours($time),
            ];
        }

        cache()->put('summary:' . $duration, $results, 5);

        return $results;
    }

    protected function transformSchedule($scheduled, $summary, $timer)
    {
        $scheduled->time = 0;

        if (array_key_exists($scheduled->client->label, $summary)) {
            $scheduled->time = $summary[$scheduled->client->label]['decimal'];
        }

        if (! is_null($timer) && $timer['client']['id'] === (int)$scheduled->client->toggl_id) {
            $duration        = time() + $timer['duration'];
            $scheduled->time = $scheduled->time + (decimalHours(convertMicroSecondsArray($duration)));
        }

        return $scheduled;
    }
}
