<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $reviews = [
            [
                'id' => Str::ulid(),
                'name' => 'সাবিহা আক্তার',
                'designation' => 'এইচএসসি শিক্ষার্থী, ঢাকা',
                'comment' => 'এই প্ল্যাটফর্ম থেকে আমি যেভাবে গাইডলাইন পেয়েছি, তা আমার জীবনের মোড় ঘুরিয়ে দিয়েছে।',
                'rating' => 5,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'রাফসান জামান',
                'designation' => 'ব্যাচেলর স্টুডেন্ট, চট্টগ্রাম',
                'comment' => 'ইংলিশ কোর্সটা একদম প্র্যাকটিকাল। এখন আমি আত্মবিশ্বাসের সাথে কথা বলতে পারি।',
                'rating' => 4,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'তাসনিম রাইসা',
                'designation' => 'স্কুল শিক্ষার্থী',
                'comment' => 'অ্যাকাডেমিক ভিডিও কনটেন্টগুলো অনেক হেল্পফুল, সহজ ভাষায় সব বুঝি।',
                'rating' => 5,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'নাফিস রহমান',
                'designation' => 'সরকারি চাকরি প্রস্তুতি',
                'comment' => 'MCQ প্র্যাকটিস মডিউলগুলো আমাকে বিসিএস প্রস্তুতিতে অনেক সাহায্য করেছে।',
                'rating' => 5,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'মাহি সুলতানা',
                'designation' => 'স্কিল ডেভেলপমেন্ট শিক্ষার্থী',
                'comment' => 'স্কিল কোর্সগুলো অনেক প্রফেশনাল লেভেলের এবং ইন্সট্রাক্টররাও খুব ভালো।',
                'rating' => 4,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'রিজওয়ান হোসেন',
                'designation' => 'এসএসসি পরীক্ষার্থী',
                'comment' => 'স্মার্টভাবে শেখার জন্য এই প্ল্যাটফর্ম সেরা। প্রতিটি লেকচার খুব সুন্দরভাবে বোঝানো।',
                'rating' => 5,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'আসিফুল হক',
                'designation' => 'ফ্রিল্যান্সার',
                'comment' => 'আমি এখানে গ্রাফিক্স ডিজাইন শিখে এখন মার্কেটপ্লেসে কাজ করছি। ধন্যবাদ এই প্ল্যাটফর্মকে।',
                'rating' => 5,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'নাইমা নূর',
                'designation' => 'ইংলিশ ব্যাচ শিক্ষার্থী',
                'comment' => 'প্র্যাকটিকাল এক্সারসাইজ আর ভয়েস টেস্টের মাধ্যমে আমার স্পোকেন ইংলিশ অনেক ভালো হয়েছে।',
                'rating' => 4,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'ফারহান খান',
                'designation' => 'একাডেমিক ব্যাচ',
                'comment' => 'এই প্ল্যাটফর্মের নোট এবং গাইডগুলো আমার পরীক্ষার প্রস্তুতিতে অনেক হেল্প করেছে।',
                'rating' => 5,
            ],
            [
                'id' => Str::ulid(),
                'name' => 'সানজিদা তাসনিম',
                'designation' => 'ইন্টারমিডিয়েট শিক্ষার্থী',
                'comment' => 'এক্সাম ব্যাচ ও কুইজ ফিচারগুলো আমার জন্য খুবই উপকারী হয়েছে।',
                'rating' => 5,
            ],
        ];

        $course = Course::query()->where('slug', 'microsoft-powerpoint-masterclass')->firstOrFail();
        $userIds = User::query()->pluck('id')->shuffle()->values();

        foreach ($reviews as $index => $review) {

            Review::query()->create(array_merge($review, [
                'course_id' => $course->id,
                'user_id' => $userIds[$index],
                'featured' => true,
                'approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
