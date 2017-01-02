<?php

namespace App\Http\Controllers;

use App\Apis\Asana\Client as AsanaClient;
use App\Apis\Toggl\Client as TogglClient;

class HomeController extends BaseController
{
    public function index(TogglClient $toggle, AsanaClient $asana)
    {
        $this->setPageTitle('JumpGate Demo');

        return $this->view();
    }
}
