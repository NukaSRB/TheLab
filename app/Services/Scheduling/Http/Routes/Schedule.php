<?php

namespace App\Services\Scheduling\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Schedule extends BaseRoutes implements Routes
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
        $router->get('edit/{userId}/{date}')
               ->name('admin.schedule.edit')
               ->uses('Schedule@edit');

        $router->post('edit/{userId}/{date}')
               ->name('admin.schedule.edit')
               ->uses('Schedule@update');

        $router->get('new-project/{id}/{date}')
               ->name('admin.schedule.new-project')
               ->uses('Schedule@getProject');
    }
}
