<?php

namespace App\Services\Clients\Http\Controllers;

use App\Services\Clients\Models\Client;
use Backpack\CRUD\app\Http\Controllers\CrudController;

class ClientCrud extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Client::class);
        $this->crud->setRoute('admin/client');
        $this->crud->setEntityNameStrings('client', 'clients');

        $this->crud->enableAjaxTable();
        $this->crud->allowAccess('show');

        $this->setColumns();
        $this->setFields();
    }

    public function show($id)
    {
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;

        return view('admin.client.show', $this->data);
    }

    private function setColumns()
    {
        $this->crud->setColumns([
            [
                'name'  => 'label',
                'label' => 'Name',
            ],
            'abbreviation',
            [
                'name'  => 'color',
                'label' => 'Color',
                'type'  => 'color',
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
            'name'  => 'abbreviation',
            'label' => 'Abbreviation',
        ]);
        $this->crud->addField([
            'name'  => 'color',
            'type'  => 'color_picker',
            'label' => 'Color',
        ]);
        $this->crud->addField([
            'name'  => 'toggl_id',
            'label' => 'Toggl ID',
        ]);
        $this->crud->addField([
            'name'  => 'asana_id',
            'label' => 'Asana ID',
        ]);
    }
}
