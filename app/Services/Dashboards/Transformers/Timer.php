<?php

namespace App\Services\Dashboards\Transformers;

use App\Apis\Toggl\Client;

class Timer
{
    protected $togglClient;

    public function __construct()
    {
        $this->togglClient = app(Client::class);
    }

    public static function transform($timer = null)
    {
        list($client, $project, $task) = self::getDetails($timer);

        return array_merge($timer, [
            'project' => $project,
            'client'  => $client,
            'task'    => $task,
        ]);
    }

    private static function getDetails($timer)
    {
        $togglClient = app(Client::class);

        $project = $togglClient->handle('GetProject', ['id' => $timer['pid']]);
        $client  = $togglClient->handle('GetClient', ['id' => $project['cid']]);
        $task    = $togglClient->handle('GetTask', ['id' => $timer['tid']]);

        return [
            $client,
            $project,
            $task,
        ];
    }
}
