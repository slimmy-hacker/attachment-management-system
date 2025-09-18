<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('1212'),
                'role' => 'admin',
            ],
            [
                'name' => 'Student User',
                'email' => 'student@example.com',
                'password' => Hash::make('1212'),
                'role' => 'student',
            ],
            [
                'name' => 'School Supervisor',
                'email' => 'schoolsupervisor@example.com',
                'password' => Hash::make('1212'),
                'role' => 'school_supervisor',
            ],
            [
                'name' => 'Industrial Supervisor',
                'email' => 'industrial@example.com',
                'password' => Hash::make('1212'),
                'role' => 'industrial_supervisor',
            ],
            [
                'name' => 'Company',
                'email' => 'company@example.com',
                'password' => Hash::make('1212'),
                'role' => 'company',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // prevent duplicates
                $user
            );
        }
    }
}
