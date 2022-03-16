<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use JumpGate\Menu\DropDown;
use JumpGate\Menu\Link;

class AdminSidebar
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
        self::generateMenu();
    }

    public static function generateMenu()
    {
        $menu = \Menu::getMenu('adminMenu');

        $menu->link('admin.dashboard', function (Link $link) {
            $link->name = 'Admin Dashboard';
            $link->url  = route('admin.index');
        });
        $menu->link('admin.artisan', function (Link $link) {
            $link->name = 'Artisan';
            $link->url  = route('admin.artisan.index');
        });
        $menu->dropDown('admin.users', 'Users', function (DropDown $dropDown) {
            $dropDown->link('admin.users.index', function (Link $link) {
                $link->name = 'List Users';
                $link->url  = route('admin.users.index');
            });
            $dropDown->link('admin.users.status.index', function (Link $link) {
                $link->name = 'List Statuses';
                $link->url  = route('admin.users.status.index');
            });
        });

        return $menu;
    }
}
