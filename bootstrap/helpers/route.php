<?php

// @todo - Figure out which way to do this is best
if (! function_exists('routeIs')) {
    /**
     * Add the active class to an element if the url matchs the arguments.
     *
     * @param  string[] $controller An array of controller then action arguments to check for.
     * @param  bool     $justActive Return class="active" or just active.
     *
     * @return string
     */
    function routeIs($controller, $justActive = false)
    {
        if (! is_array($controller)) {
            if ($controller == '/' && Request::segment(1) == null) {
                return "class='active'";
            }
            if (Request::segment(1) == $controller) {
                if ($justActive) {
                    return 'active';
                } else {
                    return "class='active'";
                }
            }
        } else {
            if (Request::segment(1) == $controller[0]
                && Request::segment(2) == $controller[1]
            ) {
                if ($justActive) {
                    return 'active';
                } else {
                    return "class='active'";
                }
            }
        }

        return false;
    }
}

if (! function_exists('routeActive')) {
    function routeActive($route, $children = [], $simple = false)
    {
        $found        = false;
        $currentRoute = Route::getCurrentRoute()->getName();

        if ($children instanceof Illuminate\Support\Collection) {
            $children = $children->toArray();
        }

        if ($route == $currentRoute || in_array($currentRoute, $children)) {
            $found = true;
        } elseif (substr($route, -1) == '*' && checkPartialRoute($route, $currentRoute) == true) {
            $found = true;
        } else {
            foreach ($children as $child) {
                if (checkPartialRoute($child, $currentRoute) == true) {
                    $found = true;
                    break;
                }
            }
        }

        if ($found == true) {
            if ($simple) {
                return 'active';
            } else {
                return "class='active'";
            }
        }
    }

    /**
     * @param $route
     * @param $currentRoute
     *
     * @return array
     */
    function checkPartialRoute($route, $currentRoute)
    {
        $routeParts = explode('.', $currentRoute);
        $wildCard   = array_pop($routeParts);

        $currentRoute = implode('.', $routeParts) . '.';

        if (substr($route, 0, -1) == $currentRoute) {
            return true;
        }

        return false;
    }
}

if (! function_exists('cleanRoute')) {
    /**
     * Convert a Route object into a view location.
     *
     * @param      $route
     * @param bool $returnArray
     *
     * @return array|mixed|string
     */
    function cleanRoute($route, $returnArray = false)
    {
        $route         = str_replace('_', '.', $route);
        $routeParts    = explode('@', $route);
        $routeParts[1] = preg_replace('/^get/', '', $routeParts[1]);
        $routeParts[1] = preg_replace('/^post/', '', $routeParts[1]);
        $route         = strtolower(str_replace('Controller', '', implode('.', $routeParts)));

        if ($returnArray == true) {
            $route = explode('.', $route);
        }

        return $route;
    }
}

if (! function_exists('resourceRoute')) {
    /**
     * Add standard resource routes for a controller.
     *
     * @param       $controller
     * @param       $name
     * @param array $middleware
     */
    function resourceRoute($controller, $name, $middleware = [])
    {
        app('router')->group(['prefix' => $name, 'middleware' => $middleware], function () use ($controller, $name) {
            app('router')->get('create', [
                'as'   => $name . '.create',
                'uses' => $controller . '@create',
            ]);
            app('router')->post('create', [
                'as'   => $name . '.create',
                'uses' => $controller . '@store',
            ]);
            app('router')->get('edit/{id}', [
                'as'   => $name . '.edit',
                'uses' => $controller . '@edit',
            ]);
            app('router')->post('edit/{id}', [
                'as'   => $name . '.edit',
                'uses' => $controller . '@update',
            ]);
            app('router')->get('delete/{id}', [
                'as'   => $name . '.delete',
                'uses' => $controller . '@destroy',
            ]);
            app('router')->get('/{id}', [
                'as'   => $name . '.show',
                'uses' => $controller . '@show',
            ]);
            app('router')->get('/', [
                'as'   => $name . '.index',
                'uses' => $controller . '@index',
            ]);
        });
    }
}
