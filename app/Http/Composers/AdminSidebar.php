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
        $menu = app('menu')->getMenu('adminMenu');

        $menu->link('admin.dashboard', function (Link $link) {
            $link->name = 'Dashboard';
            $link->icon = 'fa-chart-simple';
            $link->url  = route('admin.index');
        });
        $menu->dropDown('admin.users', 'Users', function (DropDown $dropDown) {
            $dropDown->link('admin.users.index', function (Link $link) {
                $link->name = 'List Users';
                $link->icon = 'fa-users';
                $link->url  = route('admin.users.index');
            });
            $dropDown->link('admin.users.create', function (Link $link) {
                $link->name = 'Add User';
                $link->icon = 'fa-user-plus';
                $link->url  = route('admin.users.create');
            });
            $dropDown->link('admin.users.status.index', function (Link $link) {
                $link->name = 'List Statuses';
                $link->icon = 'fa-user-lock';
                $link->url  = route('admin.users.status.index');
            });
        });
        $menu->dropDown('admin.tools', 'Tools', function (DropDown $dropDown) {
            $dropDown->link('admin.tools.pulse', function (Link $link) {
                $link->name    = 'Pulse';
                $link->icon    = 'fa-radar';
                $link->url     = route('pulse');
                $link->inertia = false;
            });
            $dropDown->link('admin.tools.telescope', function (Link $link) {
                $link->name    = 'Telescope';
                $link->icon    = 'fa-bug';
                $link->url     = route('telescope');
                $link->inertia = false;
            });
        });

        return $menu;
    }
}
