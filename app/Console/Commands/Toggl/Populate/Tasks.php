<?php

namespace App\Console\Commands\Toggl\Populate;

use App\Apis\Toggl\Client;
use App\Services\Clients\Models\Project;
use App\Services\Clients\Models\Task;
use Illuminate\Console\Command;

class Tasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toggl:populate:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take all tasks from toggl and store locally.  (This will not overwrite existing tasks)';

    /**
     * @var \App\Apis\Toggl\Client
     */
    private $client;

    /**
     * @var \App\Services\Clients\Models\Project
     */
    private $projects;

    /**
     * @var \App\Services\Clients\Models\Task
     */
    private $tasks;

    /**
     * @param \App\Apis\Toggl\Client               $client
     * @param \App\Services\Clients\Models\Project $projects
     * @param \App\Services\Clients\Models\Task    $tasks
     */
    public function __construct(Client $client, Project $projects, Task $tasks)
    {
        parent::__construct();

        $this->client   = $client;
        $this->projects = $projects;
        $this->tasks    = $tasks;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        collect($this->client->handle('GetWorkspaceTasks', ['id' => (int)env('TOGGL_WORKSPACE_ID')]))->each(function ($task) {
            $project = $this->projects->where('toggl_id', $task['pid'])->first();

            if (is_null($project)) {
                return true;
            }

            $this->tasks->firstOrCreate(
                [
                    'toggl_id' => $task['id'],
                ],
                [
                    'toggl_id'          => $task['id'],
                    'project_id'        => $project->id,
                    'label'             => $task['name'],
                    'estimated_seconds' => isset($task['estimated_seconds']) ? $task['estimated_seconds'] : null,
                    'active_flag'       => $task['active'],
                ]
            );
        });
    }
}
