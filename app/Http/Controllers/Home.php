<?php

namespace App\Http\Controllers;

use Tightenco\Ziggy\Ziggy;

class Home extends Base
{
    public function index()
    {
        $loggedIn = auth()->check();
        $this->setTheme('dark');

        return $this->response(
            compact('loggedIn'),
            'Home/Index'
        );
    }
}
