<?php

namespace App\Console\Commands\Toggl\Populate;

use App\Apis\Toggl\Client;
use App\Services\Clients\Models\Client as ClientModel;
use Illuminate\Console\Command;

class All extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toggl:populate:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate clients, projects and tasks.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('toggl:populate:clients');
        $this->call('toggl:populate:projects');
        $this->call('toggl:populate:tasks');
    }
}
