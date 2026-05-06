<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setting(['general' => [
            "site_name" => "Grameen School",
            "tagline" => "Learn. Grow. Succeed",
            "theme_color" => "#0d9488",
            "dark_mode" => "false",
            "language" => "en",
            "timezone" => "Asia/Dhaka",
            "website_url" => "https://grameenschool.com",
            "maintenance_mode" => "false",
        ]])->save();

        setting([
            "contact" => [
                "phone" => "০১৭১২২৫০৯৫৭",
                "email" => "info@grameenschool.com",
                "address" => "আমবাগান, সেনওয়ালিয়া-১৩৪৪, <br> থানাঃ আশুলিয়া, উপজেলাঃ সাভার, ঢাকা ।",
                "whatsapp" => "01712250957",
                "facebook" => "https://facebook.com/grameenschool",
                "twitter" => "https://twitter.com/grameenschool",
                "linkedin" => "https://linkedin.com/in/grameenschool",
                "youtube" => "https://youtube.com/grameenschool"
            ],
        ])->save();

        setting([
            'seo' => [
                "meta_title" => "Best Online Learning Platform - Grameen School",
                "meta_description" => "Join Grameen School and start learning from the best instructors online.",
                "meta_keywords" => "online learning, elearning, grameen school",
                "og_image" => Storage::disk(config('app.disk'))->url('og_image.png'),
            ]
        ])->save();


        setting(['hero' => [
            'title' => 'স্বপ্নপূরণের প্রস্তুতি শুরু হোক আজই',
            'headline' => 'লাইভ ক্লাস, মাস্টারবুক ও ফুল গাইডে সম্পূর্ণ প্রস্তুতি',
            'overview' => 'দেশসেরা শিক্ষকদের সাথে ঘরে বসে পড়াশোনার পূর্ণ সুবিধা। <br/> যেকোনো জায়গা থেকে, যেকোনো সময় – শেখা হবে সহজ, গুছানো এবং নিশ্চিত।',
            'image_url' => Storage::disk(config('app.disk'))->url('hero.webp'), // image url or null
        ]])->save();

        setting(['bundles' => [
            'title' => 'আমাদের জনপ্রিয় কোর্স বাণ্ডেলসমূহ',
            'overview' => 'এখানে আপনি আপনার শিক্ষার লক্ষ্য অনুযায়ী বিভিন্ন অনলাইন কোর্স বাণ্ডেল খুঁজে পাবেন। প্রতিটি বাণ্ডেলে একাধিক কোর্স সংযুক্ত আছে, যাতে সহজেই ধারাবাহিকভাবে পড়াশোনা করতে পারেন।',
        ]])->save();


        setting(['topCategories' => [
            'title' => 'জনপ্রিয় ক্যাটাগরি সমূহ',
            'overview' => 'আমাদের সেরা ক্যাটাগরি গুলো একনজরে দেখে নিন এবং আপনার দক্ষতা উন্নয়নের জন্য সঠিক বিষয়টি বেছে নিন। বিস্তারিত জানতে প্রতিটি ক্যাটাগরিতে ক্লিক করুন।',
        ]])->save();

        setting(['benefits' => [
            'title' => 'বছরজুড়ে অনলাইন ব্যাচে কী পাচ্ছে শিক্ষার্থীরা?',
            'overview' => 'দেশসেরা শিক্ষকদের নিবিড় তত্ত্বাবধানে, দেশের যেকোন প্রান্ত থেকে নিয়মিত ও কার্যকর শিক্ষায় গড়ে উঠুক তোমার স্বপ্নের প্রস্তুতি — নিরবিচারে, সহজেই, ঘরে বসেই।',
        ]])->save();

        setting(['testimonials' => [
            'title' => 'শিক্ষার্থীদের অভিমত',
            'overview' => 'আমাদের কোর্সগুলো করে শত শত শিক্ষার্থী তাদের লক্ষ্য অর্জনের পথে এগিয়ে যাচ্ছে। নিচে তাদের কিছু মূল্যবান অভিমত দেখুন।',
        ]])->save();

        setting(['instructors' => [
            'title' => 'আমাদের সেরা প্রশিক্ষকরা',
            'overview' => 'অভিজ্ঞ ও দক্ষ প্রশিক্ষকদের কাছ থেকে শিখুন, যারা শিক্ষাদানে অনুরাগী এবং আপনার সফলতায় অঙ্গীকারবদ্ধ। প্রতিটি প্রশিক্ষক বাস্তব অভিজ্ঞতা ও আকর্ষণীয় উপস্থাপনার মাধ্যমে আপনাকে দ্রুত অগ্রসর হতে সাহায্য করবে।',
        ]])->save();


        setting(['cta' => [
            'title' => 'ডাউনলোড করুন আমাদের মোবাইল অ্যাপ,',
            'subtitle' => 'শেখা শুরু করুন আজ থেকেই',
            'app_links' => [
                'google_play' => 'https://play.google.com/store/apps/details?id=com.grameenschoolbd.app',
                'app_store' => 'https://apps.apple.com/app/id123456789',
            ],
            'social' => [
                'heading' => 'আমাদের সাথে যুক্ত থাকুন',
                'description' => 'নতুন আপডেট, কোর্স ও লাইভ সেশনের খবর পেতে ফলো করুন আমাদের সোশ্যাল মিডিয়াতে।',
                'links' => [
                    'facebook' => 'https://facebook.com',
                    'twitter' => 'https://twitter.com',
                    'instagram' => 'https://instagram.com',
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                ]
            ],
            'app_image_url' => Storage::disk(config('app.disk'))->url('app.jpg'),
        ]])->save();
    }
}
