<?php

namespace Database\Seeders;

use App\Enums\PageType;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'প্রাইভেসি পলিসি',
                'slug' => 'privacy-policy',
                'content' => '<p>Read how we handle your personal information.</p>',
                'meta_title' => 'Privacy Policy | LMS',
                'meta_description' => 'Our commitment to your privacy and data protection.',
                'meta_keywords' => 'privacy, data, policy',
                'type' => PageType::FOOTER,
                'order' => 1,
                'public' => true,
            ],
            [
                'title' => 'রিফান্ড পলিসি',
                'slug' => 'refund-policy',
                'content' => '<p>Our policy regarding course refunds.</p>',
                'meta_title' => 'Refund Policy | LMS',
                'meta_description' => 'Understand our refund rules and process.',
                'meta_keywords' => 'refund, policy, course return',
                'type' => PageType::FOOTER,
                'order' => 2,
                'public' => true,
            ],
            [
                'title' => 'ব্যবহার শর্তাবলি',
                'slug' => 'terms',
                'content' => '<p>Terms and conditions of using our platform.</p>',
                'meta_title' => 'User Terms | LMS',
                'meta_description' => 'Terms of service for students and instructors.',
                'meta_keywords' => 'terms, user agreement, policy',
                'type' => PageType::FOOTER,
                'order' => 3,
                'public' => true,
            ],


            [
                'title' => 'নোটস ও গাইড',
                'slug' => 'notes-and-guides',
                'content' => '<p>Download useful notes and course guides.</p>',
                'meta_title' => 'Notes and Guides | LMS',
                'meta_description' => 'Helpful notes and guides for better learning.',
                'meta_keywords' => 'notes, guide, help',
                'type' => PageType::FOOTER,
                'order' => 6,
                'public' => true,
            ],

            [
                'title' => 'ফ্রি ডাউনলোড',
                'slug' => 'free-download',
                'content' => '<p>Download useful notes and course guides.</p>',
                'meta_title' => 'Notes and Guides | LMS',
                'meta_description' => 'Helpful notes and guides for better learning.',
                'meta_keywords' => 'notes, guide, help',
                'type' => PageType::FOOTER,
                'order' => 6,
                'public' => true,
            ],
        ];
        foreach ($pages as $page) {
            Page::query()->create($page);
        }
    }
}
