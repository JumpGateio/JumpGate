<?php

namespace App\Http\Controllers;

use App\Traits\UsesInertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;
use JumpGate\ViewResolution\Traits\AutoResolvesViews;

abstract class Base extends Controller
{
    use AuthorizesRequests;
    use AutoResolvesViews;
    use DispatchesJobs;
    use UsesInertia;
    use ValidatesRequests;

    /**
     * Use this method to quickly switch your GET responses
     * between blade and view.
     *
     * @param array       $data
     * @param string|null $page
     * @param string|null $layout
     *
     * @return Response
     *
     * @see AutoResolvesViews::view()
     * @see AutoResolvesViews::inertia()
     */
    public function response(array $data = [], ?string $page = null, ?string $layout = null): Response
    {
        $this->setTheme('dark');

        if (routeIs('admin')) {
            $menus['adminMenu'] = app('menu')->render('adminMenu')->links;
        } else {
            $menus = [
                'leftMenu'  => app('menu')->render('leftMenu')->links,
                'rightMenu' => app('menu')->render('rightMenu')->links,
            ];
        }

        $flash = [
            'flash' => [
                'success' => session('success'),
                'error'   => session('error'),
                'errors'  => session('errors'),
            ],
        ];

        Inertia::share($menus);
        Inertia::share($flash);

        return $this->inertia($data, $page);
    }

    public function setTheme($string): void
    {
        View::share('theme', $string);
    }

    public function setViewData(string $key, mixed $data): void
    {
        View::share($key, $data);
    }
}
