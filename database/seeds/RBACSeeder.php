<?php

use Illuminate\Database\Seeder;

class RBACSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name'  => 'admin',
                'label' => 'Administrator',
            ],
            [
                'name'  => 'employee',
                'label' => 'Employee',
            ],
            [
                'name'  => 'production',
                'label' => 'Production',
            ],
            [
                'name'  => 'strategy',
                'label' => 'Strategy',
            ],
            [
                'name'  => 'marketing',
                'label' => 'Marketing',
            ],
            [
                'name'  => 'billing',
                'label' => 'Billing',
            ],
        ];

        $permissions = [
            [
                'name'  => 'administrate',
                'label' => 'Administrate',
            ],
        ];

        $rolePermissions = [
            [
                'role_id'       => 1,
                'permission_id' => 1,
            ],
        ];

        \Illuminate\Support\Facades\DB::table('acl_roles')->insert($roles);
        \Illuminate\Support\Facades\DB::table('acl_permissions')->insert($permissions);
        \Illuminate\Support\Facades\DB::table('acl_permission_role')->insert($rolePermissions);
    }
}
