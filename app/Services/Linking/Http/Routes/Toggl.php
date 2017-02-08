<?php

namespace App\Services\Linking\Http\Routes;

use Jumpgate\Core\Contracts\Routes;
use Jumpgate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Toggl extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Linking\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('default') . '/link/toggl';
    }

    public function middleware()
    {
        return [
            'web',
            'auth.no_toggl',
            'active:user_link',
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
        $router->get('/')
               ->name('link.toggl')
               ->uses('Toggl@edit');

        $router->post('/')
               ->name('link.toggl')
               ->uses('Toggl@update');
    }
}
