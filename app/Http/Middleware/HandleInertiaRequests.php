<?php

namespace App\Http\Middleware;

use App\Http\Collectors\InertiaCollector;
use App\Http\Composers\Menu;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'layouts.inertia';

    public function __construct()
    {
        if (checkDebugbar()) {
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
     * @param  \Illuminate\Http\Request $request
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function share(Request $request)
    {
        Menu::getMenus();

        return array_merge(parent::share($request), [
            'leftMenu'  => \Menu::render('leftMenu')->links,
            'rightMenu' => \Menu::render('rightMenu')->links,
            'flash'     => [
                'success' => session()->get('success'),
                'error'   => session()->get('error'),
            ],
        ]);
    }
}
