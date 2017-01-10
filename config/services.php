<?php

return [
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],

    'gitlab' => [
        'client_id'     => env('GITLAB_CLIENT_ID'),
        'client_secret' => env('GITLAB_CLIENT_SECRET'),
        'redirect'      => env('GITLAB_REDIRECT_URI'),
    ],
];
