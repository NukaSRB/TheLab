<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JumpGate\Core\Http\Controllers\BaseController as CoreBaseController;
use JumpGate\Menu\Link;

abstract class BaseController extends CoreBaseController
{
    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;

    protected function setPageTitle($customPageTitle)
    {
        $this->setViewData(compact('customPageTitle'));
    }

    /**
     * Add an item to the breadcrumbs from anywhere in the controllers.
     *
     * @param $title
     * @param $route
     */
    protected function addBreadcrumb($title, $route)
    {
        $breadcrumbs = \Menu::getMenu('breadcrumbs');

        $breadcrumbs->link($title, function (Link $link) use ($title, $route) {
            $link->name = $title;
            $link->url  = $route;
        });
    }
}
