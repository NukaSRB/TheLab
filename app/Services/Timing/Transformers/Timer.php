<?php

namespace App\Services\Timing\Transformers;

use App\Apis\Toggl\Client;
use App\Transformers\Transformer;

class Timer extends Transformer
{
    protected $togglClient;

    public function __construct()
    {
        $this->togglClient = app(Client::class);
    }

    public static function transform($resource)
    {
        list($client, $project, $task) = self::getDetails($resource);

        return array_merge($resource, [
            'project' => $project,
            'client'  => $client,
            'task'    => $task,
        ]);
    }

    private static function getDetails($resource)
    {
        $togglClient = app(Client::class);

        $project = $togglClient->handle('GetProject', ['id' => $resource['pid']]);
        $client  = $togglClient->handle('GetClient', ['id' => $project['cid']]);
        $task    = $togglClient->handle('GetTask', ['id' => $resource['tid']]);

        return [
            $client,
            $project,
            $task,
        ];
    }
}
