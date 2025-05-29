<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'username' => 'user1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            // Add more users as needed
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
