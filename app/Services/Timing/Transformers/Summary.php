<?php

namespace App\Services\Timing\Transformers;

use App\Apis\Toggl\Client;
use App\Transformers\Transformer;

class Summary extends Transformer
{
    protected $togglClient;

    public function __construct()
    {
        $this->togglClient = app(Client::class);
    }

    public static function transform($resource)
    {
        $time = convertMicroSecondsArray($resource['time'] / 1000);

        return [
            'client'  => $resource['title']['client'],
            'time'    => $time,
            'decimal' => decimalHours($time),
        ];
    }
}
