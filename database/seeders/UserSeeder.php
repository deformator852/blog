<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Diana Prince',
                'email' => 'diana@example.com',
                'password' => 'password123',
            ],
            [
                'name' => 'Ethan Hunt',
                'email' => 'ethan@example.com',
                'password' => 'password123',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
        }
    }
}
