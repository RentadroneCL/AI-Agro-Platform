<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::where(['name' => 'administrator'])
            ->firstOr(function () {
                Role::create([
                    'name' => 'administrator',
                    'guard_name' => 'web',
                ]);
            });
    }
}
