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

        return $rightMenu;
    }
}
