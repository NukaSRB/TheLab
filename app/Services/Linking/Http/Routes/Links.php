<?php

namespace App\Services\Linking\Http\Routes;

use Jumpgate\Core\Contracts\Routes;
use Jumpgate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Links extends BaseRoutes implements Routes
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
        $router->get('redirect/{driver}')
               ->name('link.redirect')
               ->uses('Link@redirect');

        $router->get('callback/{driver}')
               ->name('link.callback')
               ->uses('Link@callback');
    }
}
