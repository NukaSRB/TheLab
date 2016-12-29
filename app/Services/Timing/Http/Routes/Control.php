<?php

namespace App\Services\Timing\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Control extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Timing\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('default') . '/timer';
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
        $router->get('stop/{id}')
              ->name('timer.stop')
              ->uses('Control@stop');
    }
}
