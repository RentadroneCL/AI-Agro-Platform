<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'browse',
            'create',
            'read',
            'update',
            'delete',
        ];

        foreach ($permissions as $permission) {
            Permission::where(['name' => $permission])
                ->firstOr(function () use ($permission) {
                    Permission::create([
                        'name' => $permission,
                        'guard_name' => 'web',
                    ]);
                });
        }

        $administrator = Role::where(['name' => 'administrator'])->first();
        $administrator->syncPermissions($permissions);
    }
}
