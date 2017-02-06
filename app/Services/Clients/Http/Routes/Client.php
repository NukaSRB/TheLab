<?php

namespace App\Services\Clients\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Client extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Clients\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('admin') . '/client';
    }

    public function middleware()
    {
        return [
            'web',
            'auth',
            'active:admin_client',
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
               ->name('admin.client.create')
               ->uses('ClientCrud@create');
        $router->post('create')
               ->name('admin.client.create')
               ->uses('Client@store');

        $router->get('{id}/edit')
               ->name('admin.client.edit')
               ->uses('ClientCrud@edit');
        $router->post('{id}/edit')
               ->name('admin.client.edit')
               ->uses('Client@update');

        $router->delete('{id}/delete')
               ->name('admin.client.delete')
               ->uses('Client@destroy');

        $router->get('{id}')
               ->name('admin.client.show')
               ->uses('ClientCrud@show');

        $router->any('search')
               ->name('admin.client.search')
               ->uses('ClientCrud@search');

        $router->get('/')
               ->name('admin.client.index')
               ->uses('ClientCrud@index');
    }
}
