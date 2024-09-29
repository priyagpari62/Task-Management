<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Priyagpari Goswami',           // Full Name
            'email' => 'priyagpari62@gmail.com',  // Email
            'email_verified_at' => now(),   // Email verification timestamp
            'password' => Hash::make('password123'), // Hashed password
            'remember_token' => Str::random(10),     // Remember token
        ]);

        User::create([
            'name' => 'Pratik Patel',           // Full Name
            'email' => 'pratik001@gmail.com',  // Email
            'email_verified_at' => now(),   // Email verification timestamp
            'password' => Hash::make('password123'), // Hashed password
            'remember_token' => Str::random(10),     // Remember token
        ]);
    }
}
