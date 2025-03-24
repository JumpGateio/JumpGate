<?php

namespace App\Http\Controllers;

use App\Traits\AutoResolvesViews;
use App\Traits\UsesInertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

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
     * @see AutoResolvesViews::view()
     * @see AutoResolvesViews::inertia()
     *
     * @param array       $data
     * @param null|string $page
     * @param null|string $layout
     *
     * @return \Inertia\Response
     */
    public function response(array $data = [], ?string $page = null, ?string $layout = null): \Inertia\Response
    {
        $menus = [
//            'leftMenu'  => menu()->render('leftMenu')->links,
//            'rightMenu' => menu()->render('rightMenu')->links,
//            'adminMenu' => menu()->render('adminMenu')->links,
        ];

        Inertia::share($menus);

        return $this->inertia($data, $page);
    }
}
