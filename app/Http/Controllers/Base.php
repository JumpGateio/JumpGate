<?php

namespace App\Http\Controllers;

use App\Traits\UsesInertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use JumpGate\ViewResolution\Traits\AutoResolvesViews;

abstract class Base extends Controller
{
    use AuthorizesRequests,
        AutoResolvesViews,
        UsesInertia,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * Use this method to quickly switch your GET responses
     * between blade and view.
     *
     * @param array       $data
     * @param null|string $page
     * @param null|string $layout
     *
     * @return \Inertia\Response
     * @see AutoResolvesViews::view()
     * @see AutoResolvesViews::inertia()
     *
     */
    public function response(array $data = [], ?string $page = null, ?string $layout = null): \Inertia\Response
    {
        $this->setTheme('dark');
        $menus = [
            'leftMenu'  => app('menu')->render('leftMenu')->links,
            'rightMenu' => app('menu')->render('rightMenu')->links,
            'adminMenu' => app('menu')->render('adminMenu')->links,
        ];

        Inertia::share($menus);

        return $this->inertia($data, $page);
    }

    public function setTheme($string): void
    {
        View::share('theme', $string);
    }
}
