<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JumpGate\ViewResolution\Traits\AutoResolvesViews;
use JumpGate\Core\Http\Controllers\BaseController as CoreBaseController;

abstract class BaseController extends CoreBaseController
{
    use AuthorizesRequests, AutoResolvesViews, DispatchesJobs, ValidatesRequests;

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
    public function response($data = [], $page = null, $layout = null)
    {
        return $this->inertia($data, $page);
    }
}
