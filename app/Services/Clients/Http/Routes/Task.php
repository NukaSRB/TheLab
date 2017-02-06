<?php

namespace App\Services\Clients\Http\Routes;

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
        return $this->getContext('admin') . '/task';
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
        $router->get('create')
               ->name('admin.task.create')
               ->uses('TaskCrud@create');
        $router->post('create')
               ->name('admin.task.create')
               ->uses('Task@store');

        $router->get('{id}/edit')
               ->name('admin.task.edit')
               ->uses('TaskCrud@edit');
        $router->post('{id}/edit')
               ->name('admin.task.edit')
               ->uses('Task@update');

        $router->delete('{id}/delete')
               ->name('admin.task.delete')
               ->uses('Task@destroy');

        $router->get('{id}')
               ->name('admin.task.show')
               ->uses('TaskCrud@show');

        $router->any('search')
               ->name('admin.task.search')
               ->uses('TaskCrud@search');

        $router->get('/')
               ->name('admin.task.index')
               ->uses('TaskCrud@index');
    }
}
