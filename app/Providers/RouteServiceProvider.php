<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Route providers that contain the configuration of a route group.
     *
     * @var array
     */
    protected $providers = [
        \App\Http\Routes\Admin::class,
        \App\Http\Routes\Home::class,

        \JumpGate\Users\Http\Routes\Guest::class,
        \JumpGate\Users\Http\Routes\Auth::class,

        \App\Services\Clients\Http\Routes\Client::class,
        \App\Services\Clients\Http\Routes\Project::class,
        \App\Services\Clients\Http\Routes\Task::class,

        \App\Services\Dashboards\Http\Routes\Production::class,

        \App\Services\Linking\Http\Routes\Index::class,
        \App\Services\Linking\Http\Routes\Links::class,

        \App\Services\Scheduling\Http\Routes\Schedule::class,

        \App\Services\Timing\Http\Routes\Control::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app['router'];

        foreach ($this->providers as $provider) {
            $provider = new $provider;

            $router->patterns($provider->patterns());
        }

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $router = $this->app['router'];

        foreach ($this->providers as $provider) {
            $provider = new $provider;

            $router->group([
                'prefix'     => $provider->prefix(),
                'namespace'  => $provider->namespacing(),
                'middleware' => $provider->middleware(),
            ], function ($router) use ($provider) {
                $provider->routes($router);
            });
        }
    }
}
