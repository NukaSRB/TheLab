<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->setViewLayout('layouts.admin');
    }

    public function index()
    {
        return $this->view();
    }
}
