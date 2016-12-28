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
    }

    public function index()
    {
        $this->setViewData('clients', $this->clients->orderByNameAsc()->paginate(15));

        return $this->view();
    }

    public function edit($id)
    {
        $this->setViewData('client', $this->clients->find($id));

        return $this->view();
    }
}
