<?php

namespace App\Http\Controllers;

use App\Events\TestBroadcasting;

class Home extends Base
{
    public function index()
    {
        $loggedIn = auth()->check();

        // Test Broadcasting
        broadcast(new TestBroadcasting());

        return $this->response(
            compact('loggedIn'),
            'Home/Index'
        );
    }
}
