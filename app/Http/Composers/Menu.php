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
        $leftMenu = \Menu::getMenu('leftMenu');

        // $leftMenu->link('docs', function (Link $link) {
        //     $link->name    = 'Documentation';
        //     $link->url     = route('larecipe.index');
        //     $link->inertia = false;
        // });

        return $leftMenu;
    }

    /**
     * Adds items to the menu that appears on the right side of the main menu.
     */
    public static function generateRightMenu()
    {
        $rightMenu = \Menu::getMenu('rightMenu');

        if (auth()->guest()) {
            $rightMenu->link('login', function (Link $link) {
                $link->name    = 'Login';
                $link->url     = route(
                    config('jumpgate.users.default_route.name'),
                    config('jumpgate.users.default_route.options')
                );
                $link->inertia = false;
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
                if (auth()->user()->hasRole(['developer', 'admin'])) {
                    $dropDown->link('user_admin', function (Link $link) {
                        $link->name = 'Admin';
                        $link->url  = route('admin.index');
                    });
                    // TODO: Uncomment if using events.  Remove if not.
                    // $dropDown->link('user_websockets', function (Link $link) {
                    //     $link->name = 'Websockets Dashboard';
                    //     $link->url  = route('home') . '/laravel-websockets';
                    // });
                    // TODO: Uncomment if using telescope.  Remove if not.
                    // $dropDown->link('user_telescope', function (Link $link) {
                    //     $link->name    = 'Telescope';
                    //     $link->url     = route('telescope');
                    //     $link->inertia = false;
                    // });
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
