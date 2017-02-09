<?php

namespace App\Services\Clients\Http\Routes;

use Backpack\CRUD\CrudServiceProvider;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Task extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Clients\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('admin');
    }

    public function middleware()
    {
        return [
            'web',
            'auth',
            'active:admin_task',
        ];
    }

    public function patterns()
    {
        return [
            'id' => '[0-9]+',
        ];
    }

    public function routes(Router $router)
    {
        CrudServiceProvider::resource('task', 'TaskCrud');
    }
}
