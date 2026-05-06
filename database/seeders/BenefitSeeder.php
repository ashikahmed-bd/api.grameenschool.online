<?php

namespace Database\Seeders;

use App\Enums\Provider;
use App\Models\Benefit;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $benefits = [
            [
                'title' => 'সারা বছরে কী কী হচ্ছে অনলাইন ব্যাচে?',
                'description' => 'এক্সপার্ট টিচারদের লাইভ ক্লাস, গোছানো মাস্টারবুক, ও মডেল টেস্ট দিয়ে ঘরে বসেই ৬ষ্ঠ-১০ম শ্রেণির পড়াশোনার কমপ্লিট প্রিপারেশন!',
                'banner' => '/benefits/1.jpg',
                'provider' => Provider::YOUTUBE,
                'video_id' => 'F5VmxS6WZmw',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'সারা বছর সেরা রেজাল্ট',
                'description' => 'পুরো বছরের পারফেক্ট পড়াশোনার প্ল্যানে সারা বছর ৬ষ্ঠ-১০ম শ্রেণির সব পরীক্ষার সেরা প্রস্তুতি ঘরে বসেই।',
                'banner' => '/benefits/2.jpg',
                'provider' => Provider::YOUTUBE,
                'video_id' => 'F5VmxS6WZmw',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($benefits as $benefit) {
            Benefit::query()->create($benefit);
        }
    }
}
