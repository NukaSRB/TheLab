<?php

namespace App\Services\Clients\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\Clients\Models\Task as TaskModel;

class Task extends BaseController
{
    /**
     * @var \App\Services\Clients\Models\Task
     */
    private $tasks;

    /**
     * Task constructor.
     *
     * @param \App\Services\Clients\Models\Task $tasks
     */
    public function __construct(TaskModel $tasks)
    {
        $this->tasks = $tasks;

        $this->addBreadcrumb('Tasks', route('admin.task.index'));
    }

    public function index()
    {
        $this->setViewData('tasks', $this->tasks->with('project.client')->orderByNameAsc()->paginate(15));

        return $this->view();
    }

    public function show($id)
    {
        $task = $this->tasks->with('project.client', 'project.tasks')->find($id);

        $this->setViewData('task', $task);
        $this->addBreadcrumb('Task: ' . $task->label, null);

        return $this->view();
    }

    public function create()
    {
        return $this->view();
    }

    public function store()
    {
        dd(request()->all());
    }

    public function edit($id)
    {
        $this->setViewData('task', $this->tasks->find($id));

        return $this->view();
    }

    public function update($id)
    {
        dd(request()->all());
    }

    public function destroy($id)
    {
        $this->tasks->find($id)->delete();

        return redirect(route('admin.task.index'))
            ->with('message', 'Task deleted');
    }
}
