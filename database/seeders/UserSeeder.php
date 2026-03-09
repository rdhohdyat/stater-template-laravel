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

        $users = [
            ['name' => 'Alice Johnson', 'email' => 'alice@nexadash.io', 'status' => 'active', 'bio' => 'UI Designer'],
            ['name' => 'Bob Smith', 'email' => 'bob@nexadash.io', 'status' => 'active', 'bio' => 'Backend Developer'],
            ['name' => 'Charlie Brown', 'email' => 'charlie@nexadash.io', 'status' => 'inactive', 'bio' => 'Project Manager'],
            ['name' => 'Diana Prince', 'email' => 'diana@nexadash.io', 'status' => 'active', 'bio' => 'Frontend Developer'],
            ['name' => 'Edward Norton', 'email' => 'edward@nexadash.io', 'status' => 'active', 'bio' => 'DevOps Engineer'],
            ['name' => 'Fiona Green', 'email' => 'fiona@nexadash.io', 'status' => 'inactive', 'bio' => 'QA Engineer'],
            ['name' => 'George Clark', 'email' => 'george@nexadash.io', 'status' => 'active', 'bio' => 'Data Analyst'],
            ['name' => 'Hannah Lee', 'email' => 'hannah@nexadash.io', 'status' => 'active', 'bio' => 'Product Manager'],
            ['name' => 'Ivan Drago', 'email' => 'ivan@nexadash.io', 'status' => 'inactive', 'bio' => 'Mobile Developer'],
            ['name' => 'Julia Roberts', 'email' => 'julia@nexadash.io', 'status' => 'active', 'bio' => 'UX Researcher'],
        ];

        foreach ($users as $user) {
            \App\Models\User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => 'user',
                    'status' => $user['status'],
                    'bio' => $user['bio'],
                    'foto_profile' => null,
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
