<?php

namespace App\Services\Timing\Http\Controllers;

use App\Apis\Toggl\Client;
use App\Http\Controllers\BaseController;
use App\Services\Clients\Models\Task;
use App\Services\Dashboards\Transformers\Timer;
use App\Services\Timing\Commands\Timer as TimerCommand;

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
            'tid'          => $task->toggl_id,
            'billable'     => (boolean)$task->project->billable_flag,
        ];

        // todo - check if this exists
        $timer = $this->toggl->setApiKey(auth()->user()->getProvider('toggl')->token)
                           ->handle('StartTimeEntry', ['time_entry' => $timeEntry]);

        $timer = command(TimerCommand::class, $timer, true);

        return response()->json($timer, 200);
    }

    public function update($id)
    {
        $timeEntry = request()->except('_token');

        if (isset($timeEntry['billable'])) {
            $timeEntry['billable'] = (boolean)$timeEntry['billable'];
        }

        // todo - check if this exists
        $timer = $this->toggl->setApiKey(auth()->user()->getProvider('toggl')->token)
                             ->handle('UpdateTimeEntry', ['id' => (int)$id, 'time_entry' => $timeEntry]);

        $timer = command(TimerCommand::class, $timer, true);

        return response()->json($timer, 200);
    }

    public function stop($id)
    {
        // todo - check if this exists
        $this->toggl->setApiKey(auth()->user()->getProvider('toggl')->token)
                    ->handle('StopTimeEntry', ['id' => (int)$id]);

        return back()
            ->with('message', 'Timer stopped.');
    }

    public function delete($id)
    {
        // todo - check if this exists
        $this->toggl->setApiKey(auth()->user()->getProvider('toggl')->token)
                    ->handle('DeleteTimeEntry', ['id' => (int)$id]);

        return back()
            ->with('message', 'Timer deleted.');
    }
}
