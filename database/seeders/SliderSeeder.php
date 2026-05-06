<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'শেখা হোক আনন্দে!',
                'subtitle' => 'এক জায়গায় স্কুল ও কলেজের সম্পূর্ণ প্রস্তুতি! আমাদের প্ল্যাটফর্মে রয়েছে ভিডিও লেকচার, টেস্ট সিরিজ, এবং ফ্রি ক্লাস যা আপনাকে আপনার পড়াশোনায় সাহায্য করবে। এখনই শুরু করুন এবং শেখার আনন্দ উপভোগ করুন!',
                'image' => 'sliders/1.png',
                'link' => '/admission',
                'text' => 'ফ্রি ক্লাস বুক করুন',
                'target' => '_self',
                'sort_order' => 1,
                'active' => true,
                'disk' => config('app.disk'),
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
