<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert(config('permission_data.permissions'));
        Role::insert(config('role_data.roles'));

        $permissions = [];
        foreach (config('permission_data.permissions') as $permission) {
            array_push($permissions, $permission['name']);
        }
        Role::findByName('super.admin', 'api')->syncPermissions($permissions);
    }
}
