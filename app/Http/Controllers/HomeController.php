<?php

namespace App\Http\Controllers;

use App\Apis\Asana\Client as AsanaClient;
use App\Apis\Toggl\Client as TogglClient;

class HomeController extends BaseController
{
    public function index(TogglClient $toggle, AsanaClient $asana)
    {
        $this->setPageTitle('JumpGate Demo');

        // $user = $asana->findTeamsByOrganization(8744492949110);
        // dump(count($user));
        // foreach ($user as $team) {
        //     dump($team);
        // }

        // $clients = collect($toggle->handle('GetClients', ['page' => 2]));
        // dump($clients->pluck('name', 'id'));

        $time = $toggle
            ->setApiKey(env('A_TOGGL_KEY'))
            ->handle('GetCurrentTimeEntry');
        dump($time);

        return $this->view();
    }
}
