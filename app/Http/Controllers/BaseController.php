<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use NukaCode\Core\Http\Controllers\BaseController as CoreBaseController;

abstract class BaseController extends CoreBaseController
{
    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

    public function __construct()
    {
        parent::__construct();

        $this->setUpJavascript();
    }

    protected function setPageTitle($pageTitle)
    {
        $this->setViewData(compact('pageTitle'));
    }
}
