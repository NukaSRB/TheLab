<?php

namespace App\Console\Commands\Toggl\Populate;

use App\Apis\Toggl\Client;
use App\Services\Clients\Models\Client as ClientModel;
use App\Services\Clients\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Projects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toggl:populate:projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take all projects from toggl and store locally.  (This will not overwrite existing projects)';

    /**
     * @var \App\Apis\Toggl\Client
     */
    private $client;

    /**
     * @var \App\Services\Clients\Models\Client
     */
    private $clients;

    /**
     * @var \App\Services\Clients\Models\Project
     */
    private $projects;

    /**
     * @param \App\Apis\Toggl\Client               $client
     * @param \App\Services\Clients\Models\Client  $clients
     * @param \App\Services\Clients\Models\Project $projects
     */
    public function __construct(Client $client, ClientModel $clients, Project $projects)
    {
        parent::__construct();

        $this->client   = $client;
        $this->clients  = $clients;
        $this->projects = $projects;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        collect($this->client->handle('GetProjects', ['id' => (int)env('TOGGL_WORKSPACE_ID')]))->each(function ($project) {
            $client = $this->clients->where('toggl_id', $project['cid'])->first();

            $this->projects->firstOrCreate([
                'toggl_id'        => $project['id'],
                'client_id'       => $client->id,
                'label'           => $project['name'],
                'color'           => substr($project['hex_color'], 1),
                'rate'            => isset($project['rate']) ? $project['rate'] : null,
                'estimated_hours' => isset($project['estimated_hours']) ? $project['estimated_hours'] : null,
                'billable_flag'   => $project['billable'],
                'active_flag'     => $project['active'],
                'private_flag'    => $project['is_private'],
            ]);
        });
    }
}
