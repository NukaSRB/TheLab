<?php

namespace App\Services\Timing\Http\Controllers;

use App\Apis\Toggl\Client;
use App\Http\Controllers\BaseController;

class Control extends BaseController
{
    /**
     * @var \App\Apis\Toggl\Client
     */
    private $toggl;

    /**
     * Control constructor.
     *
     * @param \App\Apis\Toggl\Client $toggl
     */
    public function __construct(Client $toggl)
    {
        $this->toggl = $toggl;
    }

    public function start()
    {
        $timeEntry                 = request()->except('_token');
        $timeEntry['created_with'] = 'The Lab';

        // todo - convert this to user's API key
        $this->toggl->setApiKey('7cc984f789e75be10f47762f8144643c')
                    ->handle('StartTimeEntry', compact('timeEntry'));

        return back()
            ->with('message', 'Timer started.');
    }

    public function stop($id)
    {
        // todo - convert this to user's API key
        $this->toggl->setApiKey('7cc984f789e75be10f47762f8144643c')
                    ->handle('StopTimeEntry', ['id' => (int)$id]);

        return back()
            ->with('message', 'Timer stopped.');
    }
}
