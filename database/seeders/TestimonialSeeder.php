<?php

namespace Database\Seeders;

use App\Enums\Provider;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'মোঃ রিয়াজ',
                'tagline' => 'ঢাকা বিশ্ববিদ্যালয় - কম্পিউটার সায়েন্স',
                'photo' => '',
                'cover' => 'testimonials/cover.png',
                'video_id' => 'F5VmxS6WZmw',
                'provider' => Provider::YOUTUBE,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'সুমাইয়া আফরোজ',
                'tagline' => 'জাহাঙ্গীরনগর বিশ্ববিদ্যালয়- গণিত',
                'photo' => '',
                'cover' => 'testimonials/cover.png',
                'video_id' => 'F5VmxS6WZmw',
                'provider' => Provider::YOUTUBE,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'রাহাত হোসেন',
                'tagline' => 'চট্টগ্রাম বিশ্ববিদ্যালয় - ফিজিক্স',
                'photo' => '',
                'cover' => 'testimonials/cover.png',
                'video_id' => 'F5VmxS6WZmw',
                'provider' => Provider::YOUTUBE,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ফাতিমা নূর',
                'tagline' => 'রাজশাহী বিশ্ববিদ্যালয় - ইংরেজি',
                'photo' => '',
                'cover' => 'testimonials/cover.png',
                'video_id' => 'F5VmxS6WZmw',
                'provider' => Provider::YOUTUBE,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
