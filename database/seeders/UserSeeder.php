<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fixed Admin Account
        \App\Models\User::updateOrCreate(
        ['email' => 'admin@nexadash.io'],
        [
            'name' => 'Admin Nexa',
            'role' => 'admin',
            'status' => 'active',
            'bio' => 'Administrator of NexaDash System.',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'email_verified_at' => now(),
        ]
        );

        // Fixed Regular User Account
        \App\Models\User::updateOrCreate(
        ['email' => 'john@nexadash.io'],
        [
            'name' => 'John Doe',
            'role' => 'user',
            'status' => 'active',
            'bio' => 'Regular user of the platform.',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'email_verified_at' => now(),
        ]
        );

        // Generate 10 dummy users
        \App\Models\User::factory(10)->create();
    }
}
