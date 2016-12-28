<?php

namespace App\Http\Controllers;

use App\Apis\Toggl\Client;

class HomeController extends BaseController
{
    public function index(Client $client)
    {
        $this->setPageTitle('JumpGate Demo');

        $clients = collect($client->handle('GetClients', ['page' => 2]));
        dump($clients->pluck('name', 'id'));

        return $this->view();
    }
}
