<?php

namespace App\Services\Admin\Http\Controllers;

use App\Http\Composers\AdminSidebar;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;

class Base extends BaseController
{
    public function __construct()
    {
        $this->setViewLayout('layouts.admin');
        $this->setViewData('bodyClass', 'admin');
    }
}
