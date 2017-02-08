<?php

namespace App\Services\Linking\Http\Controllers;

use App\Http\Controllers\BaseController;

class Toggl extends BaseController
{
    public function edit()
    {
        return $this->view();
    }

    public function update()
    {
        $token = request()->get('token');

        $provider = auth()->user()->getProvider('toggl');
        $provider->update(compact('token'));

        return redirect(route('link.index'))
            ->with('message', 'Toggl token added.');
    }
}
