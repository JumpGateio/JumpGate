<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use JumpGate\Menu\DropDown;
use JumpGate\Menu\Link;

class Menu
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $this::getMenus();
    }

    public static function getMenus()
    {
        self::generateLeftMenu();
        self::generateRightMenu();
    }

    /**
     * Adds items to the menu that appears on the left side of the main menu.
     */
    public static function generateLeftMenu()
    {
        $leftMenu = app('menu')->getMenu('leftMenu');

        // Place any menu you want on the left side here.

        return $leftMenu;
    }

    /**
     * Adds items to the menu that appears on the right side of the main menu.
     */
    public static function generateRightMenu()
    {
        $rightMenu = app('menu')->getMenu('rightMenu');

        if (auth()->guest()) {
            $rightMenu->link('login', function (Link $link) {
                $socialOnly = config('jumpgate.users.social_auth_only');

                if ($socialOnly) {
                    $route     = route('auth.social.login', config('jumpgate.users.providers.0.driver'));
                    $inertia   = false;
                } else {
                    $route      = route('auth.login');
                    $inertia    = true;
                }

                $link->name    = 'Login';
                $link->url     = $route;
                $link->inertia = $inertia;
            });

            // Don't show a link if we don't allow registration.
            if (config('jumpgate.users.settings.allow_registration')) {
                $rightMenu->link('register', function (Link $link) {
                    $link->name = 'Register';
                    $link->url  = route('auth.register');
                });
            }
        }

        if (auth()->check()) {
            $rightMenu->dropdown('user', auth()->user()->display_name, function (DropDown $dropDown) {
                if (auth()->user()->hasPermission(['access-admin'])) {
                    $dropDown->link('user_admin', function (Link $link) {
                        $link->name = 'Admin';
                        $link->url  = route('admin.index');
                    });
                }
                $dropDown->link('user_logout', function (Link $link) {
                    $link->name = 'Logout';
                    $link->url  = route('auth.logout');
                });
            });
        }

        return $rightMenu;
    }
}
