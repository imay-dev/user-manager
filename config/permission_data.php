<?php

return [

    'permissions' => [

        // User Operations
        [
            'name' => 'user.index',
            'guard_name' => 'api',
        ],
        [
            'name' => 'user.store',
            'guard_name' => 'api',
        ],
        [
            'name' => 'user.show',
            'guard_name' => 'api',
        ],
        [
            'name' => 'user.update',
            'guard_name' => 'api',
        ],
        [
            'name' => 'user.destroy',
            'guard_name' => 'api',
        ],
        [
            'name' => 'user.syncRolesAndPermissions',
            'guard_name' => 'api',
        ],

        // Permission Operations
        [
            'name' => 'permission.index',
            'guard_name' => 'api',
        ],
        [
            'name' => 'permission.store',
            'guard_name' => 'api',
        ],
        [
            'name' => 'permission.show',
            'guard_name' => 'api',
        ],
        [
            'name' => 'permission.update',
            'guard_name' => 'api',
        ],
        [
            'name' => 'permission.destroy',
            'guard_name' => 'api',
        ],
        [
            'name' => 'permission.syncRoles',
            'guard_name' => 'api',
        ],

        // Role Operations
        [
            'name' => 'role.index',
            'guard_name' => 'api',
        ],
        [
            'name' => 'role.store',
            'guard_name' => 'api',
        ],
        [
            'name' => 'role.show',
            'guard_name' => 'api',
        ],
        [
            'name' => 'role.update',
            'guard_name' => 'api',
        ],
        [
            'name' => 'role.destroy',
            'guard_name' => 'api',
        ],
        [
            'name' => 'role.syncPermissions',
            'guard_name' => 'api',
        ],

    ],

];
