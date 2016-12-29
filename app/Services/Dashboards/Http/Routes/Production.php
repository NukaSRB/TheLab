<?php

namespace App\Services\Dashboards\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Production extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Dashboards\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('default') . '/dashboards/production';
    }

    public function middleware()
    {
        return [
            'web',
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
               ->name('dashboards.production.index')
               ->uses('Production');
    }
}
