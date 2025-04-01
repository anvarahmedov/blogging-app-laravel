<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => bcrypt(env("ADMIN_PASSWORD ")),  // Use a secure password
            'role' => 'ADMIN',
        ]);
    }
}
