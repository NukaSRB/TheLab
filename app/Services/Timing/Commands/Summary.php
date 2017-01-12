<?php

namespace App\Services\Timing\Commands;

use App\Apis\Toggl\Client;
use App\Services\Timing\Transformers\Summary as SummaryTransformer;
use Carbon\Carbon;

class Summary
{
    /**
     * @var \App\Apis\Toggl\Client
     */
    private $toggl;

    /**
     * Timer constructor.
     *
     * @param \App\Apis\Toggl\Client $toggl
     */
    public function __construct(Client $toggl)
    {
        $this->toggl = $toggl;
    }

    public function __invoke()
    {
        if (! auth()->user()->hasProvider('toggl')) {
            return null;
        }

        $togglUser = auth()->user()->getProvider('toggl')->social_id;

        $dailySummary  = $this->getSummary($togglUser, 'day');
        $weeklySummary = $this->getSummary($togglUser, 'week');

        return [
            $dailySummary,
            $weeklySummary,
        ];
    }

    private function getSummary($togglUser, $duration)
    {

        $cacheKey = 'toggl:summaries:' . $duration . ':' . $togglUser;

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
                'user_ids'     => $togglUser,
            ]);

        $summary = SummaryTransformer::transformAll($summary['data'])
                                     ->keyBy('client');

        cache()->put($cacheKey, $summary, 5);
    }
}
