<?php

namespace App\Services\Timing\Transformers;

use App\Apis\Toggl\Client;
use App\Services\Clients\Models\Project;
use App\Services\Clients\Models\Task;
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
        $task    = Task::where('toggl_id', $resource['tid'])->first();
        $project = $task->project;
        $client  = $project->client;

        return [
            $client,
            $project,
            $task,
        ];
    }
}
