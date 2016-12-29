<?php

namespace App\Apis\Asana;

use Asana\Client as AsanaClient;

class Client
{
    protected $client;

    public function __construct()
    {
        $this->client = AsanaClient::accessToken(env('ASANA_TOKEN'));
    }

    public function findTeamsByOrganization($organization)
    {
        return $this->client->teams->findByOrganization($organization, [], ['page_size' => 100]);
    }

    public function me()
    {
        return $this->client->users->me();
    }
}
