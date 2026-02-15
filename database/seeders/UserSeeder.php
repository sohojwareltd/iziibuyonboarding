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
        $merchantRole = Role::firstOrCreate(
            ['name' => 'Merchant'],
            ['description' => 'Merchant user']
        );
        $reviewerRole = Role::firstOrCreate(
            ['name' => 'User'],
            ['description' => 'Internal KYC reviewer']
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

        User::firstOrCreate(
            ['email' => 'merchant@iziibuy.com'],
            [
                'name' => 'Merchant',
                'last_name' => 'User',
                'role_id' => $merchantRole->id,
                'password' => Hash::make('password'),
                'phone' => '+44 7700 900000',
                'address' => '456 Merchant Lane',
                'city' => 'Manchester',
                'state' => 'Greater Manchester',
                'postal_code' => 'M1 1AE',
                'country' => 'UK',
            ]
        );

        User::firstOrCreate(
            ['email' => 'reviewer@iziibuy.com'],
            [
                'name' => 'KYC',
                'last_name' => 'Reviewer',
                'role_id' => $reviewerRole->id,
                'password' => Hash::make('password'),
                'phone' => '+44 7700 900111',
                'address' => '789 Review Ave',
                'city' => 'Birmingham',
                'state' => 'West Midlands',
                'postal_code' => 'B1 1AA',
                'country' => 'UK',
            ]
        );
    }
}
