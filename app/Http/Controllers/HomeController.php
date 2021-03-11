<?php

namespace App\Http\Controllers;

use Tightenco\Ziggy\Ziggy;

class HomeController extends BaseController
{
    public function index()
    {
        $loggedIn = auth()->check();

        return $this->render(
            'Home/Index',
            compact('loggedIn')
        );
    }

    /**
     * This returns the ziggy routes and configs to the JS framework.
     * Customize thr returned routes here.  Check the config in
     * configs/ziggy.php for the except rule that is used.
     */
    public function ziggy()
    {
        if (auth()->check()) {
            // Validate the user and what they have access to.
            $routes = new Ziggy;
        } else {
            $routes = new Ziggy;
        }

        // Return only the public routes.
        return response()->json($routes);
    }
}
