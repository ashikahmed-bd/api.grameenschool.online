<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            [
                'name' => 'ষষ্ঠ শ্রেণি',
                'slug' => 'grade-6',
                'sort_order' => 6,
            ],
            [
                'name' => 'সপ্তম শ্রেণি',
                'slug' => 'grade-7',
                'sort_order' => 7,
            ],
            [
                'name' => 'অষ্টম শ্রেণি',
                'slug' => 'grade-8',
                'sort_order' => 8,
            ],
            [
                'name' => 'নবম শ্রেণি',
                'slug' => 'grade-9',
                'sort_order' => 9,
            ],
            [
                'name' => 'দশম শ্রেণি',
                'slug' => 'grade-10',
                'sort_order' => 10,
            ],
            [
                'name' => 'একাদশ শ্রেণি',
                'slug' => 'grade-11',
                'sort_order' => 11,
            ],
            [
                'name' => 'দ্বাদশ শ্রেণি',
                'slug' => 'grade-12',
                'sort_order' => 12,
            ],
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }
    }
}
