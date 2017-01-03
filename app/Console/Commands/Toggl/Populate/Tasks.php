<?php

namespace App\Console\Commands\Toggl\Populate;

use App\Apis\Toggl\Client;
use App\Services\Clients\Models\Client as ClientModel;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Tasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toggl:populate:clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take all clients from toggl and store locally.  (This will not overwrite existing clients)';

    /**
     * @var \App\Apis\Toggl\Client
     */
    private $client;

    /**
     * @var \App\Services\Clients\Models\Client
     */
    private $clients;

    /**
     * @param \App\Apis\Toggl\Client              $client
     * @param \App\Services\Clients\Models\Client $clients
     */
    public function __construct(Client $client, ClientModel $clients)
    {
        parent::__construct();

        $this->client  = $client;
        $this->clients = $clients;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        collect($this->client->handle('GetClients'))->each(function ($client) {
            $name = array_get($client, 'name');
            $id   = array_get($client, 'id');

            $this->clients->firstOrCreate([
                'label'    => $name,
                'toggl_id' => $id,
            ]);
        });
    }
}
