<?php

namespace App\Services\Clients\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Project extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Clients\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('admin') . '/project';
    }

    public function middleware()
    {
        return [
            'web',
            'active:admin_project',
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
               ->name('admin.project.create')
               ->uses('Project@create');
        $router->post('create')
               ->name('admin.project.create')
               ->uses('Project@store');

        $router->get('{id}/edit')
               ->name('admin.project.edit')
               ->uses('Project@edit');
        $router->post('{id}/edit')
               ->name('admin.project.edit')
               ->uses('Project@update');

        $router->delete('{id}/delete')
               ->name('admin.project.delete')
               ->uses('Project@destroy');

        $router->get('{id}')
               ->name('admin.project.show')
               ->uses('Project@show');

        $router->get('/')
               ->name('admin.project.index')
               ->uses('Project@index');
    }
}
