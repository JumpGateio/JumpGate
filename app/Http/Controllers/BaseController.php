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
}
