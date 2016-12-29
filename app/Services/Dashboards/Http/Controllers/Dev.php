<?php

namespace App\Services\Dashboards\Http\Controllers;

use App\Apis\Toggl\Client as TogglClient;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;

class Dev extends BaseController
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

        $this->setViewData(compact('timer', 'dailySummary', 'weeklySummary'));

        return $this->view();
    }

    /**
     * @return mixed|null
     */
    private function getActiveTimer()
    {
        // todo - convert this to user's API key
        $timer = $this->toggl->setApiKey('7cc984f789e75be10f47762f8144643c')->handle('GetCurrentTimeEntry');

        if (isset($timer['data']) && is_null($timer['data'])) {
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
        if (cache()->has('summary:'. $duration)) {
            return cache('summary:'. $duration);
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
                // 'user_ids'     => 1777547, // Travis
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

        cache()->put('summary:'. $duration, $results, 5);

        return $results;
    }
}
