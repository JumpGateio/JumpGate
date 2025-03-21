<?php

namespace App\Contracts;

use Illuminate\Routing\Router;

interface Routes
{
    public function setContext(string $name, string $uri);

    public function getContext(?string $name);

    public function getNamespace();

    public function getPrefix();

    public function getMiddleware();

    public function getPatterns();

    public function getRole();

    public function getPermissions();

    public function routes(Router $router);
}
