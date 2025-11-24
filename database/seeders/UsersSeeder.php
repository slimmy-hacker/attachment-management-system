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
                'email' => 'admin@dams.com',
                'password' => Hash::make(config('app.default_password')),
                'role' => 'admin',
                'phone_number' => '254722000000',
            ]
        ];

        foreach ($users as $user) {
            try {


                User::updateOrCreate(
                    ['email' => $user['email']],
                    $user
                );
            }catch (\Exception $e){
                echo $e->getMessage();

            }
        }
    }
}

