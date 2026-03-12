<?php

namespace App\Services\Admin\Http\Controllers;

use App\Http\Controllers\Base as BaseController;

class Base extends BaseController
{
    public function __construct()
    {
        $this->setViewData('bodyClass', 'admin');
    }
}
