<?php

namespace App\Services\Clients\Http\Controllers;

use App\Services\Clients\Models\Project;
use App\Services\Clients\Models\Task;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\DB;

class TaskCrud extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Task::class);
        $this->crud->addClause('with', 'project.client');
        $this->crud->setRoute('admin/task');
        $this->crud->setEntityNameStrings('task', 'tasks');

        $this->crud->enableAjaxTable();
        $this->crud->allowAccess('show');

        $this->setFilters();
        $this->setColumns();
        $this->setFields();
    }

    public function show($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud']  = $this->crud;
        $this->data['title'] = trans('backpack::crud.preview') . ' ' . $this->crud->entity_name;

        return view('admin.task.show', $this->data);
    }

    private function setFilters()
    {
        $this->crud->addFilter(
            [
                'type'  => 'Select2',
                'name'  => 'client',
                'label' => 'Client',
            ],
            function () {
                return DB::table('clients')
                         ->orderBy('label', 'asc')
                         ->pluck('label', 'id')
                         ->toArray();
            },
            function ($value) {
                $projectIds = DB::table('client_projects')
                                ->where('client_id', $value)
                                ->get(['id'])
                                ->flatMap(function ($project) {
                                    return [$project->id];
                                })->toArray();

                $this->crud->addClause('whereIn', 'project_id', $projectIds);
            });

        $this->crud->addFilter(
            [
                'type'  => 'Select2',
                'name'  => 'project',
                'label' => 'Project',
            ],
            function () {
                return DB::table('client_projects')
                         ->orderBy('label', 'asc')
                         ->pluck('label', 'id')
                         ->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'project_id', $value);
            });
    }

    private function setColumns()
    {
        $this->crud->setColumns([
            [
                'name'  => 'label',
                'label' => 'Name',
            ],
            [
                'name'      => 'project_id',
                'label'     => 'Project',
                'entity'    => 'project',
                'attribute' => 'label',
                'type'      => 'select',
            ],
            [
                'name'      => 'label',
                'attribute' => 'project.client',
                'label'     => 'Client',
                'type'      => 'chain',
            ],
            [
                'name'  => 'toggl_id',
                'label' => 'Toggl',
                'type'  => 'toggl_link',
            ],
        ]);
    }

    private function setFields()
    {
        $this->crud->addField([
            'name'  => 'label',
            'label' => 'Label',
        ]);
        $this->crud->addField([
            'name'      => 'project_id',
            'label'     => 'Project',
            'type'      => 'select2',
            'entity'    => 'project',
            'attribute' => 'clientAndLabel',
            'model'     => Project::class,
        ]);
        $this->crud->addField([
            'name'  => 'toggl_id',
            'label' => 'Toggl ID',
        ]);
        $this->crud->addField([
            'name'  => 'active_flag',
            'label' => 'Active',
            'type'  => 'checkbox',
        ]);
    }
}
