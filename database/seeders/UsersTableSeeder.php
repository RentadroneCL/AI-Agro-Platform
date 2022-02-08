<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // default admin
        $administrator = User::create([
            'name' => 'Rentadrone.cl',
            'email' => 'contacto@rentadrone.cl',
            'email_verified_at' => now()->toDateTimeString(),
            'password' => Hash::make('password'),
        ]);

        $administrator->assignRole('administrator');

        $administrator->ownedTeams()
            ->create([
                'name' => 'Rentadrone',
                'personal_team' => 1,
            ]);
    }
}
