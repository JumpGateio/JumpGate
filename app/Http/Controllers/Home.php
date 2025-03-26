<?php

namespace App\Http\Controllers;

use Tightenco\Ziggy\Ziggy;

class Home extends Base
{
    public function index()
    {
        $loggedIn = auth()->check();

        return $this->response(
            compact('loggedIn'),
            'Home/Index'
        );
    }
}
