<?php

namespace App\Http\Middleware;

use App\Http\Collectors\InertiaCollector;
use App\Http\Composers\AdminSidebar;
use App\Http\Composers\Menu;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    public function __construct()
    {
        if (app()->environment('local') && app()->bound('debugbar')) {
            $debugbar = app('debugbar');

            if ($debugbar->shouldCollect('inertia')) {
                $debugbar->addCollector(new InertiaCollector());
            }
        }
    }


    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function share(Request $request)
    {
        Menu::getMenus();
        
        if (auth()->check() && auth()->user()->hasPermission('access-admin')) {
            AdminSidebar::getMenus();
        }

        return array_merge(parent::share($request), [
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ]);
    }
}
