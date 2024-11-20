<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{
    User,
    Role
};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or retrieve the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create or retrieve the user role
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create a test admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password') // Set a secure password here
            ]
        );

        // Create a test regular user
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password') // Set a secure password here
            ]
        );

        // Attach the roles to the respective users
        $adminUser->roles()->attach($adminRole->id); // Attach admin role
        $regularUser->roles()->attach($userRole->id); // Attach user role

        // Save the users with their roles
        $adminUser->save();
        $regularUser->save();
    }
}
