<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'email' => 'manager@gmail.com',
                'email_verified_at' => now(),
                'name' => 'John doe',
                'password' => '12345678',
                'role' => 'manager',
            ],
            [
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'name' => 'Anna Smith',
                'password' => '12345678',
                'role' => 'user',
            ],
        ];


        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'email_verified_at' => $user['email_verified_at'],
                    'password' => bcrypt($user['password']),
                ]
            )->assignRole($user['role']);;
        }

        User::factory()->count(10)->create();
    }
}
