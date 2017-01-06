<?php

namespace App\Services\Clients\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\Clients\Models\Client as ClientModel;

class Client extends BaseController
{
    /**
     * @var \App\Services\Clients\Models\Client
     */
    private $clients;

    /**
     * Client constructor.
     *
     * @param \App\Services\Clients\Models\Client $clients
     */
    public function __construct(ClientModel $clients)
    {
        $this->clients = $clients;

        $this->setViewLayout('layouts.admin');
    }

    public function index()
    {
        $this->setViewData('clients', $this->clients->orderByNameAsc()->paginate(15));

        return $this->view();
    }

    public function show($id)
    {
        $client = $this->clients->with('projects')->find($id);

        $this->setViewData('client', $client);

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
        $this->setViewData('client', $this->clients->find($id));

        return $this->view();
    }

    public function update($id)
    {
        dd(request()->all());
    }

    public function destroy($id)
    {
        $this->clients->find($id)->delete();

        return redirect(route('admin.client.index'))
            ->with('message', 'Client deleted');
    }
}
