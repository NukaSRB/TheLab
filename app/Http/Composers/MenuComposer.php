<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use JumpGate\Menu\DropDown;
use JumpGate\Menu\Link;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
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

        $leftMenu->link('home', function (Link $link) {
            $link->name = 'Home';
            $link->url  = route('home');
        });
    }

    /**
     * Adds items to the menu that appears on the right side of the main menu.
     */
    private function generateRightMenu()
    {
        $this->generateAdminMenu();
        $this->generateUserMenu();
    }

    private function generateAdminMenu()
    {
        $rightMenu = \Menu::getMenu('rightMenu');

        $rightMenu->dropDown('admin', 'Admin', function (DropDown $dropDown) {
            $dropDown->link('admin_client', function (Link $link) {
                $link->name = 'Clients';
                $link->url  = route('admin.client.index');
            });
        });
    }

    private function generateUserMenu()
    {
        $rightMenu = \Menu::getMenu('rightMenu');

        if (auth()->guest()) {
            $rightMenu->link('login', function (Link $link) {
                $link->name = 'Login';
                $link->url  = route('auth.login');
            });
        } else {
            $rightMenu->dropdown('user', auth()->user()->name, function (DropDown $dropDown) {
                $dropDown->link('user_logout', function (Link $link) {
                    $link->name = 'Logout';
                    $link->url  = route('auth.logout');
                });
            });
        }
    }
}
