<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Load Views
    |--------------------------------------------------------------------------
    |
    | JumpGate Users comes with some default bootstrap 3 view files to make
    | getting started quicker.  If you don't want these to load, set
    | this value to false.
    |
    */
    'load_views'        => true,

    /*
    |--------------------------------------------------------------------------
    | Default Role
    |--------------------------------------------------------------------------
    |
    | When a user signs up, this is the role ID they will be automatically
    | assigned to.
    |
    */
    'default'           => 'employee',

    /*
    |--------------------------------------------------------------------------
    | Social Authentication Details
    |--------------------------------------------------------------------------
    |
    | If using social authentication, specify the driver being used here.  You
    | can also specify any additional scopes or extras you need here.
    | Setting the enable_Social flag to true will change the existing routes
    | to their social counterparts.
    |
    */
    'enable_social'     => true,
    'providers'         => [
        [
            'driver' => 'google',
            'scopes' => [
                'https://www.googleapis.com/auth/calendar',
            ],
            'extras' => [
                'approval_prompt' => 'auto',
                'access_type'     => 'offline',
                // 'prompt'      => 'consent',
            ],
        ],
        [
            'driver' => 'gitlab',
            'scopes' => [],
            'extras' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Allow super users
    |--------------------------------------------------------------------------
    |
    | The users table has a super_flag built in.  When this is set to true any
    | user with that flag will bypass all permission checks.  If you do not
    | want to allow super users, set the below value to false.
    |
    */
    'allow_super_users' => false,

    /*
    |--------------------------------------------------------------------------
    | Database population
    |--------------------------------------------------------------------------
    |
    | The below entries are used when running the acl seeder.  Anything set here
    | will be set in the database when seeded.
    |
    */

    'permissions' => [
        [
            'name'  => 'administrate',
            'label' => 'Administrate',
        ],
    ],

    'roles' => [
        [
            'name'  => 'guest',
            'label' => 'Guest',
        ],
        [
            'name'  => 'admin',
            'label' => 'Admin',
        ],
    ],

    'permission_role' => [
        [
            'permission_id' => 1,
            'role_id'       => 2,
        ],
    ],

    'users' => [
        //[
        //    'username'   => 'admin',
        //    'password'   => bcrypt('test'),
        //    'first_name' => 'Admin',
        //    'last_name'  => null,
        //    'email'      => 'admin@example.com',
        //    'timezone'   => 'US/Central',
        //    'super_flag' => 1,
        //    'roles'      => [2],
        //],
    ],
];
