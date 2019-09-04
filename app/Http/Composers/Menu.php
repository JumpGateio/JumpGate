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
        $this->generateLeftMenu();
        $this->generateRightMenu();
    }

    /**
     * Adds items to the menu that appears on the left side of the main menu.
     */
    private function generateLeftMenu()
    {
        $leftMenu = \Menu::getMenu('leftMenu');

        /**
         * TODO: Larecipe is not updated to 6.0
         *
         * @link https://github.com/saleem-hadad/larecipe/pull/157
         */
        //$leftMenu->link('docs', function (Link $link) {
        //    $link->name = 'Documentation';
        //    $link->url  = route('larecipe.index');
        //});
    }

    /**
     * Adds items to the menu that appears on the right side of the main menu.
     */
    private function generateRightMenu()
    {
        $rightMenu = \Menu::getMenu('rightMenu');
    }
}
