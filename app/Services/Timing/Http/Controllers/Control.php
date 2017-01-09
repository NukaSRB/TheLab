<?php

namespace App\Services\Timing\Http\Controllers;

use App\Apis\Toggl\Client;
use App\Http\Controllers\BaseController;
use App\Services\Clients\Models\Task;
use App\Services\Dashboards\Transformers\Timer;

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
        $task = Task::find(request('task_id'));

        $timeEntry = [
            'description'  => request('description', null),
            'created_with' => 'The Lab',
            // 'wid'          => (int)env('TOGGL_WORKSPACE_ID'),
            // 'pid'          => $task->project->toggl_id,
            'tid'          => $task->toggl_id,
            'billable'     => (boolean)$task->project->billable_flag,
        ];

        // todo - convert this to user's API key
        $timer = $this->toggl->setApiKey(env('A_TOGGL_KEY'))
                           ->handle('StartTimeEntry', ['time_entry' => $timeEntry]);

        if (array_key_exists('data', $timer)) {
            $timer = null;
        }

        if (! is_null($timer)) {
            $timer = Timer::transform($timer);
        }

        return response()->json($timer, 200);
    }

    public function stop($id)
    {
        // todo - convert this to user's API key
        $this->toggl->setApiKey(env('A_TOGGL_KEY'))
                    ->handle('StopTimeEntry', ['id' => (int)$id]);

        return back()
            ->with('message', 'Timer stopped.');
    }
}
