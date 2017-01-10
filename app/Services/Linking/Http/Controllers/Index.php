<?php

namespace App\Services\Linking\Http\Controllers;

use App\Http\Controllers\BaseController;

class Index extends BaseController
{
    /**
     * Display the list of possible providers.
     *
     * @return $this
     */
    public function __invoke()
    {
        return $this->view();
    }
}
