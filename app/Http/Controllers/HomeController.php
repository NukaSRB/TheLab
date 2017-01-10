<?php

namespace App\Http\Controllers;

use Vinkla\GitLab\GitLabManager;

class HomeController extends BaseController
{
    public function index(GitLabManager $gitlab)
    {
        dd($gitlab->api('projects')->all());
        $this->setPageTitle('JumpGate Demo');

        return $this->view();
    }
}
