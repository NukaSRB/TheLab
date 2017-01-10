<?php

namespace App\Services\Linking\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Index extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Services\Linking\Http\Controllers';
    }

    public function prefix()
    {
        return $this->getContext('default') . '/link';
    }

    public function middleware()
    {
        return [
            'web',
            'auth',
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
               ->name('link.index')
               ->uses('Index');
    }
}
