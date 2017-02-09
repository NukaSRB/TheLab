<?php

namespace App\Services\Clients\Http\Controllers;

use App\Services\Clients\Models\Client as ClientModel;
use App\Services\Clients\Models\Project;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Support\Facades\DB;

class ProjectCrud extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Project::class);
        $this->crud->addClause('with', 'client');
        $this->crud->addClause('with', 'taskCount');
        $this->crud->setRoute('admin/project');
        $this->crud->setEntityNameStrings('project', 'projects');
        $this->crud->setEntityNameStrings('project', 'projects');

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

        return view('admin.project.show', $this->data);
    }

    public function store()
    {
        request()->request->set('color', substr(request('color'), 1));
        return parent::storeCrud();
    }

    public function update()
    {
        request()->request->set('color', substr(request('color'), 1));
        return parent::updateCrud();
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
                return DB::table('clients')->orderBy('label', 'asc')->pluck('label', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'client_id', $value);
            });

        $this->crud->addFilter(
            [
                'type'  => 'dropdown',
                'name'  => 'billable_flag',
                'label' => 'Billable',
            ],
            [
                0 => 'Not Billable',
                1 => 'Billable',
            ],
            function ($value) {
                $this->crud->addClause('where', 'billable_flag', $value);
            });

        $this->crud->addFilter(
            [
                'type'  => 'dropdown',
                'name'  => 'active_flag',
                'label' => 'Active',
            ],
            [
                0 => 'Inactive',
                1 => 'Active',
            ],
            function ($value) {
                $this->crud->addClause('where', 'active_flag', $value);
            });

        $this->crud->addFilter(
            [
                'type'  => 'dropdown',
                'name'  => 'private_flag',
                'label' => 'Private',
            ],
            [
                0 => 'Public',
                1 => 'Private',
            ],
            function ($value) {
                $this->crud->addClause('where', 'private_flag', $value);
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
                'name'  => 'billable_flag',
                'label' => 'Billable',
                'type'  => 'boolean_icon',
            ],
            [
                'name'  => 'active_flag',
                'label' => 'Active',
                'type'  => 'boolean_icon',
            ],
            [
                'name'  => 'private_flag',
                'label' => 'Private',
                'type'  => 'boolean_icon',
            ],
            [
                'name'      => 'client_id',
                'entity'    => 'client',
                'attribute' => 'label',
                'label'     => 'Client',
                'type'      => 'select',
            ],
            [
                'name'      => 'id',
                'label'     => 'Tasks',
                'entity'    => 'taskCount',
                'attribute' => 'count',
                'type'      => 'select',
            ],
            [
                'name'  => 'toggl_id',
                'label' => 'Toggl',
                'type'  => 'toggl_link',
            ],
            [
                'name'  => 'color',
                'label' => 'Color',
                'type'  => 'color',
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
            'name'      => 'client_id',
            'label'     => 'Client',
            'type'      => 'select2',
            'entity'    => 'client',
            'attribute' => 'label',
            'model'     => ClientModel::class,
        ]);
        $this->crud->addField([
            'name'  => 'color',
            'type'  => 'color_picker',
            'label' => 'Color',
        ]);
        $this->crud->addField([
            'name'  => 'rate',
            'label' => 'Hourly Rate',
            'type'  => 'number',
        ]);
        $this->crud->addField([
            'name'  => 'estimated_hours',
            'label' => 'Estimated Hours',
            'type'  => 'number',
        ]);
        $this->crud->addField([
            'name'  => 'toggl_id',
            'label' => 'Toggl ID',
        ]);
        $this->crud->addField([
            'name'  => 'billable_flag',
            'label' => 'Billable',
            'type'  => 'checkbox',
        ]);
        $this->crud->addField([
            'name'  => 'active_flag',
            'label' => 'Active',
            'type'  => 'checkbox',
        ]);
        $this->crud->addField([
            'name'  => 'private_flag',
            'label' => 'Private',
            'type'  => 'checkbox',
        ]);
    }
}
