<?php

namespace App\Http\Controllers;


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
