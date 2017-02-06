<?php

namespace App\Services\Scheduling\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Index extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Scheduling\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('admin') . '/schedule';
    }

    public function middleware()
    {
        return [
            'web',
            'auth',
            'acl:administrate',
        ];
    }

    public function patterns()
    {
        return [];
    }

    public function routes(Router $router)
    {
        $router->get('/')
               ->name('admin.schedule.index')
               ->uses('Index');
    }
}
