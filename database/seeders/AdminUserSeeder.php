<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@evnt.sys')->exists()) {
            User::create([
                'name' => 'SYS_ADMIN',
                'email' => 'admin@evnt.sys',
                'password' => Hash::make('rootaccess'),
                'role' => 'admin',
            ]);
            
            $this->command->info('Admin user created successfully.');
            $this->command->info('Email: admin@evnt.sys');
            $this->command->info('Password: rootaccess');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
