<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
        $users = [
            [
                'name' => 'Md Ashik Ahmed',
                'email' => 'admin@example.com',
                'phone' => '01516598533',
                'password' => bcrypt('password'),
                'role' => UserRole::ADMIN,
            ],
            [
                'name' => 'Grameen School',
                'email' => 'info@grameenschool.com',
                'phone' => '01900000000',
                'password' => bcrypt('password'),
                'role' => UserRole::ADMIN,
            ],

            [
                'name' => 'Md Faruk Khan',
                'email' => 'faruk.khan@example.com',
                'phone' => '01800000000',
                'password' => bcrypt('password'),
                'role' => UserRole::INSTRUCTOR,
            ],
            [
                'name' => 'Nayeem Islam',
                'email' => 'nayeem.student4@example.com',
                'phone' => '01910000004',
                'password' => bcrypt('password'),
                'role' => UserRole::STUDENT,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
