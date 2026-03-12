<?php

use App\Providers\AppServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\TelescopeServiceProvider;
use JumpGate\Menu\MenuServiceProvider;

return [
    AppServiceProvider::class,
    RouteServiceProvider::class,
    TelescopeServiceProvider::class,
    MenuServiceProvider::class,
];
