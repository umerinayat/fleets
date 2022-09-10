<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::findByName('admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret')
        ]);

        $user->assignRole($adminRole);

        $staffUser = \App\Models\User::factory()->create([
            'name' => 'Ali',
            'email' => 'ali@test.com',
            'password' => Hash::make('secret')
        ]);

        $staffRole = Role::findByName('staff');

        $staffUser->assignRole($staffRole);


    }
}
