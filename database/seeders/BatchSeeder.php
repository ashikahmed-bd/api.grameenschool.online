<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade = Grade::where('slug', 'grade-11')->first();

        if (!$grade) {
            return;
        }

        $batches = [
            [
                'grade_id' => $grade->id,
                'name' => 'এইচএসসি ২০২৬',
                'slug' => 'hsc-2026',
                'year' => 2026,
                'description' => 'মাস্টারবুক, মডেল টেস্ট ও রেগুলার লাইভ ক্লাস চলছে',
                'is_active' => true,
            ],
            [
                'grade_id' => $grade->id,
                'name' => 'এইচএসসি ২০২৭',
                'slug' => 'hsc-2027',
                'year' => 2027,
                'description' => 'মাস্টারবুক, মডেল টেস্ট ও রেগুলার লাইভ ক্লাস চলছে',
                'is_active' => true,
            ],
            [
                'grade_id' => $grade->id,
                'name' => 'এইচএসসি ২০২৮',
                'slug' => 'hsc-2028',
                'year' => 2028,
                'description' => 'মাস্টারবুক, মডেল টেস্ট ও রেগুলার লাইভ ক্লাস চলছে',
                'is_active' => true,
            ],
        ];

        foreach ($batches as $batch) {
            Batch::create($batch);
        }
    }
}
