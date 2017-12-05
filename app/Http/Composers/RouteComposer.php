<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;

class RouteComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $router = app('router');

        $laravelRouteList = supportCollector($router->getRoutes())
            ->flatMap(function (Route $route) {
                return [$route->getName() => '/' . $route->uri()];
            });

        view()->share(compact('laravelRouteList'));
    }
}
