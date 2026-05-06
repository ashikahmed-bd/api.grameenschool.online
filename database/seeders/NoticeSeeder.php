<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $notices = [
            [
                'title' => 'Exam Schedule Published',
                'body' => 'Final exam will be held on 25th July 2025.',
                'type' => 'notice',
                'target' => UserRole::STUDENT,
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Assignment Deadline Extended',
                'body' => 'The deadline for assignment submission is extended to 15th July.',
                'type' => 'announcement',
                'target' => UserRole::STUDENT,
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Holiday Notice',
                'body' => 'The school will remain closed on 10th July for Eid.',
                'type' => 'notice',
                'target' => UserRole::INSTRUCTOR,
                'published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($notices as $notice) {
            Notice::query()->create($notice);
        }
    }
}
