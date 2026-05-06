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
            // ---------- STUDENTS ----------
            [
                'name' => 'Rafi Ahmed',
                'email' => 'rafi.student1@example.com',
                'phone' => '01900000000',
                'password' => bcrypt('password'),
                'role' => UserRole::STUDENT,
            ],
            [
                'name' => 'Ayesha Siddique',
                'email' => 'ayesha.student2@example.com',
                'phone' => '01910000002',
                'password' => bcrypt('password'),
                'role' => UserRole::STUDENT,
            ],
            [
                'name' => 'Tanvir Hossain',
                'email' => 'tanvir.student3@example.com',
                'phone' => '01910000003',
                'password' => bcrypt('password'),
                'role' => UserRole::STUDENT,
            ],
            [
                'name' => 'Nayeem Islam',
                'email' => 'nayeem.student4@example.com',
                'phone' => '01910000004',
                'password' => bcrypt('password'),
                'role' => UserRole::STUDENT,
            ],
            [
                'name' => 'Mehdi Hasan',
                'email' => 'mehdi.student5@example.com',
                'phone' => '01910000005',
                'password' => bcrypt('password'),
                'role' => UserRole::STUDENT,
            ],

            // ---------- INSTRUCTORS ----------
            [
                'name' => 'Md Faruk Khan',
                'email' => 'faruk.khan@example.com',
                'phone' => '01800000000',
                'password' => bcrypt('password'),
                'role' => UserRole::INSTRUCTOR,
            ],
            [
                'name' => 'Aman Islam Siam',
                'email' => 'aman.siam@example.com',
                'phone' => '01800000001',
                'password' => bcrypt('password'),
                'role' => UserRole::INSTRUCTOR,
            ],
            [
                'name' => 'Sabbir Ahmed Rifat',
                'email' => 'sabbir.rifat@example.com',
                'phone' => '01800000002',
                'password' => bcrypt('password'),
                'role' => UserRole::INSTRUCTOR,
            ],
            [
                'name' => 'Mehdi Mohammed',
                'email' => 'mehdi.mohammed@example.com',
                'phone' => '01800000003',
                'password' => bcrypt('password'),
                'role' => UserRole::INSTRUCTOR,
            ],
            [
                'name' => 'Md Kamrul Hasan Shovon',
                'email' => 'kamrul.shovon@example.com',
                'phone' => '01800000004',
                'password' => bcrypt('password'),
                'role' => UserRole::INSTRUCTOR,
            ],

            [
                'name' => 'Md Ashik Ahmed',
                'email' => 'admin@example.com',
                'phone' => '01500000000',
                'password' => bcrypt('password'),
                'role' => UserRole::ADMIN,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
