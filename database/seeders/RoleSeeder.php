<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'Student',
                'slug' => 'student',
            ],
            [
                'name' => 'Lecturer',
                'slug' => 'lecturer',
            ],
            [
                'name' => 'Industrial Supervisor',
                'slug' => 'industrial_supervisor',
            ],
            [
                'name' => 'Company',
                'slug' => 'company',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
