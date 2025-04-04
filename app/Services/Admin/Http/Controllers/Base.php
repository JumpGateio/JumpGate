<?php

namespace App\Services\Admin\Http\Controllers;

use App\Http\Composers\AdminSidebar;
use App\Http\Controllers\Base as BaseController;
use Inertia\Inertia;

class Base extends BaseController
{
    public function __construct()
    {
        $this->setViewLayout('app');
        $this->setViewData('bodyClass', 'admin');
    }
}
