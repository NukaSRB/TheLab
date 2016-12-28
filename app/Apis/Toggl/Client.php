<?php

namespace App\Apis\Toggl;

use AJT\Toggl\ReportsClient;
use AJT\Toggl\TogglClient as BaseTogglClient;

/**
 * Decorator for Toggl Client.  Automatically switches APIs based on the call made.
 *
 * @author Travis Blasingame <travis@siterocket.com>
 * @copyright 2017 Emerson Media LP
 */
class Client
{
    /**
     * Call the appropriate Toggl API based on the method given.
     *
     * @param string     $method     The Toggl API method to call.
     * @param array      $parameters Parameters to pass to the API call.
     * @param bool|false $debug      Parameters to pass to the client set up.
     *
     * @return mixed
     */
    public function handle($method, $parameters = [], $debug = false)
    {
        // Set up the constuctor parameters.
        $config = [
            'debug'   => $debug,
            'api_key' => config('toggl.key'),
        ];

        // Determine which version to call.
        $version = $this->determineVersion($method);

        // Call the correct client based on the version.
        // Die and detail why if no version is found.
        if ($version == 'v8') {
            $client = BaseTogglClient::factory($config);
        } elseif ($version == 'v2') {
            $client = ReportsClient::factory($config);
        } elseif ($version === false) {
            throw new \InvalidArgumentException('Failed to determine version from method name [' . $method . '].');
        }

        // Set up the method call parameters.
        $parameters = array_merge(
            [
                'user_agent' => config('toggl.user_agent'),
            ],
            $parameters
        );

        // Call the method on the proper client.
        return call_user_func_array([$client, $method], [$parameters]);
    }

    /**
     * Get the API version based on a method name.
     *
     * @param string $methodName The method to look for.
     *
     * @return bool|string
     */
    private function determineVersion($methodName)
    {
        // Get the API details in json format.
        $v8 = json_decode(file_get_contents(base_path('vendor/ajt/guzzle-toggl/src/AJT/Toggl/services_v8.json')));
        $v2 = json_decode(file_get_contents(base_path('vendor/ajt/guzzle-toggl/src/AJT/Toggl/reporting_v2.json')));

        // Check for the method name in the version 8 and then version 2 API.
        if (array_key_exists($methodName, (array)$v8->operations)) {
            return 'v8';
        } elseif (array_key_exists($methodName, (array)$v2->operations)) {
            return 'v2';
        }

        // Fail if the method was not found.
        return false;
    }
}
