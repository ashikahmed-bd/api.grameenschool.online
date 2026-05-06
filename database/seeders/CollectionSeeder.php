<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            [
                'title' => 'ষষ্ঠ–অষ্টম শ্রেণি',
                'slug' => 'class-6-8',
                'badge' => '২০২৬ সালে ভর্তি চলছে',
                'description' => 'ষষ্ঠ থেকে অষ্টম শ্রেণির শিক্ষার্থীদের জন্য সম্পূর্ণ সিলেবাসভিত্তিক কোর্স ও লাইভ ক্লাস।',
                'icon' => 'collections/icons/1.jpg',
                'banner' => 'collections/banner.jpg',
                'sort_order' => 0,
            ],
            [
                'title' => 'নবম–দশম শ্রেণি',
                'slug' => 'class-9-10',
                'badge' => null,
                'description' => 'এসএসসি পরীক্ষার্থীদের জন্য নবম ও দশম শ্রেণির পূর্ণাঙ্গ প্রস্তুতি কোর্স।',
                'icon' => 'collections/icons/2.jpg',
                'banner' => 'collections/banner.jpg',
                'sort_order' => 1,
            ],
            [
                'title' => 'এইচএসসি ২০২৫–২০২৬',
                'slug' => 'hsc-25-26',
                'badge' => null,
                'description' => 'এইচএসসি ২০২৫–২০২৬ ব্যাচের জন্য সম্পূর্ণ সিলেবাস ও ক্র্যাশ কোর্স।',
                'icon' => 'collections/icons/3.jpg',
                'banner' => 'collections/banner.jpg',
                'sort_order' => 2,
            ],
            [
                'title' => 'এইচএসসি ২০২৭',
                'slug' => 'hsc-27',
                'badge' => null,
                'description' => 'এইচএসসি ২০২৭ ব্যাচের শিক্ষার্থীদের জন্য ফাউন্ডেশন ও বেসিক প্রস্তুতি কোর্স।',
                'icon' => 'collections/icons/4.jpg',
                'banner' => 'collections/banner.jpg',
                'sort_order' => 3,
            ],
        ];

        foreach ($collections as $collection) {
            Collection::create($collection);
        }
    }
}
