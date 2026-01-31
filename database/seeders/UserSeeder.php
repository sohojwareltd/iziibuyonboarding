<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'System administrator']
        );

        User::firstOrCreate(
            ['email' => 'sohojwareltd@gmail.com'],
            [
                'name' => 'Admin',
                'last_name' => 'User',
                'role_id' => $adminRole->id,
                'password' => Hash::make('password'),
                'phone' => '+880 1234 567890',
                'address' => '123 Admin Street',
                'city' => 'London',
                'state' => 'Greater London',
                'postal_code' => 'SW1A 1AA',
                'country' => 'UK',
            ]
        );
    }
}
