<?php

namespace App\Services\Clients\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\Clients\Models\Project as ProjectModel;

class Project extends BaseController
{
    /**
     * @var \App\Services\Clients\Models\Project
     */
    private $projects;

    /**
     * Project constructor.
     *
     * @param \App\Services\Clients\Models\Project $projects
     */
    public function __construct(ProjectModel $projects)
    {
        $this->projects = $projects;

        $this->addBreadcrumb('Projects', route('admin.project.index'));
    }

    public function index()
    {
        $this->setViewData('projects', $this->projects->with('client')->orderByNameAsc()->paginate(15));

        return $this->view();
    }

    public function show($id)
    {
        $project = $this->projects->with('client')->find($id);

        $this->setViewData('project', $project);
        $this->addBreadcrumb('Project: ' . $project->label, null);

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
        $this->setViewData('project', $this->projects->find($id));

        return $this->view();
    }

    public function update($id)
    {
        dd(request()->all());
    }

    public function destroy($id)
    {
        $this->projects->find($id)->delete();

        return redirect(route('admin.project.index'))
            ->with('message', 'Project deleted');
    }
}
