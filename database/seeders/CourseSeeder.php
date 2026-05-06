<?php

namespace Database\Seeders;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Enums\Provider;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    public function run(): void
    {

        $courses = [
            [
                'title' => 'ক্লাস ১১ বিজ্ঞান কোর্স | HSC ২০২৬ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-11-hsc-2026-science-online-course-bangladesh'),
                'overview' => 'ক্লাস ১১ বিজ্ঞান বিভাগের শিক্ষার্থীদের জন্য সম্পূর্ণ HSC ২০২৬ অনলাইন কোর্স। পদার্থবিজ্ঞান, রসায়ন, উচ্চতর গণিত ও জীববিজ্ঞান—সব বিষয় অধ্যায়ভিত্তিক ভিডিও লেকচার, PDF নোট, MCQ ও CQ প্র্যাকটিসসহ পড়ানো হবে। জাতীয় শিক্ষাক্রম ও পাঠ্যবই বোর্ড (NCTB) এর সর্বশেষ সিলেবাস অনুসরণ করে তৈরি এই কোর্সটি বোর্ড পরীক্ষায় A+ অর্জনের জন্য আদর্শ। ঘরে বসেই বাংলাদেশের সেরা অনলাইন প্রস্তুতি।',
                'meta_title' => 'ক্লাস ১১ বিজ্ঞান কোর্স HSC ২০২৬ | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'HSC ২০২৬ ক্লাস ১১ বিজ্ঞান অনলাইন কোর্স। পদার্থ, রসায়ন, গণিত ও জীববিজ্ঞান—ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে। এখনই ভর্তি হও।',
                'meta_keywords' => 'HSC 2026, Class 11 Science Course, ক্লাস ১১ বিজ্ঞান, HSC বিজ্ঞান অনলাইন কোর্স, HSC 2026 বাংলাদেশ, Class 11 Physics Chemistry Math Biology',
                'canonical_url' => 'class-11-hsc-2026-science-course',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/class-11-hsc-2026-science.webp',
            ],

            [
                'title' => 'ক্লাস ১১ বিজ্ঞান কোর্স | HSC ২০২৭ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-11-hsc-2027-science-online-course-bangladesh'),
                'overview' => 'ক্লাস ১১ বিজ্ঞান বিভাগের শিক্ষার্থীদের জন্য সম্পূর্ণ HSC ২০২৭ অনলাইন কোর্স। পদার্থবিজ্ঞান, রসায়ন, উচ্চতর গণিত ও জীববিজ্ঞান অধ্যায়ভিত্তিক ভিডিও লেকচার, PDF নোট, MCQ ও CQ প্র্যাকটিসসহ পড়ানো হবে। NCTB এর সর্বশেষ সিলেবাস ও বোর্ড প্রশ্নপ্যাটার্ন অনুসরণ করে তৈরি এই কোর্সটি শিক্ষার্থীদের কনসেপ্ট ক্লিয়ার করে পরীক্ষায় A+ অর্জনে সহায়তা করবে। বাংলাদেশের শিক্ষার্থীদের জন্য ঘরে বসে নির্ভরযোগ্য প্রস্তুতি।',
                'meta_title' => 'ক্লাস ১১ বিজ্ঞান কোর্স HSC ২০২৭ | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'HSC ২০২৭ ক্লাস ১১ বিজ্ঞান অনলাইন কোর্স। পদার্থ, রসায়ন, গণিত ও জীববিজ্ঞান—ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে।',
                'meta_keywords' => 'HSC 2027, Class 11 Science Course, ক্লাস ১১ বিজ্ঞান, HSC 2027 বাংলাদেশ, বিজ্ঞান অনলাইন কোর্স, Class 11 Physics Chemistry Math Biology',
                'canonical_url' => 'class-11-hsc-2027-science-course',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/class-11-hsc-2027-science.webp',
            ],
            [
                'title' => 'ক্লাস ১১ ব্যবসায় শিক্ষা কোর্স | HSC ২০২৬ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-11-hsc-2026-business-studies-online-course-bangladesh'),
                'overview' => 'ক্লাস ১১ ব্যবসায় শিক্ষা বিভাগের শিক্ষার্থীদের জন্য সম্পূর্ণ HSC ২০২৬ অনলাইন কোর্স। হিসাববিজ্ঞান, ফিন্যান্স ও ব্যাংকিং, ব্যবসায় সংগঠন ও ব্যবস্থাপনা এবং উৎপাদন ব্যবস্থাপনা ও বিপণন—সব বিষয় অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, MCQ ও CQ প্র্যাকটিসসহ পড়ানো হবে। NCTB এর সর্বশেষ সিলেবাস ও বোর্ড প্রশ্নপ্যাটার্ন অনুসরণ করে তৈরি এই কোর্সটি বোর্ড পরীক্ষায় ভালো ফলাফল অর্জনের জন্য বিশেষভাবে প্রস্তুত করা হয়েছে। বাংলাদেশের শিক্ষার্থীদের জন্য ঘরে বসে নির্ভরযোগ্য অনলাইন প্রস্তুতি।',
                'meta_title' => 'ক্লাস ১১ ব্যবসায় শিক্ষা কোর্স HSC ২০২৬ | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'HSC ২০২৬ ক্লাস ১১ ব্যবসায় শিক্ষা অনলাইন কোর্স। হিসাববিজ্ঞান, ফিন্যান্স, ব্যবস্থাপনা ও বিপণন—ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে।',
                'meta_keywords' => 'HSC 2026 Business Studies, Class 11 ব্যবসায় শিক্ষা, HSC ব্যবসায় শিক্ষা কোর্স, হিসাববিজ্ঞান ক্লাস ১১, ফিন্যান্স ও ব্যাংকিং HSC, Business Studies Online Course Bangladesh',
                'canonical_url' => 'class-11-hsc-2026-business-studies-course',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/class-11-hsc-2026-business.webp',
            ],
            [
                'title' => 'ক্লাস ১১ ব্যবসায় শিক্ষা কোর্স | HSC ২০২৭ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-11-hsc-2027-business-studies-online-course-bangladesh'),
                'overview' => 'ক্লাস ১১ ব্যবসায় শিক্ষা বিভাগের শিক্ষার্থীদের জন্য সম্পূর্ণ HSC ২০২৭ অনলাইন কোর্স। হিসাববিজ্ঞান, ফিন্যান্স ও ব্যাংকিং, ব্যবসায় সংগঠন ও ব্যবস্থাপনা এবং উৎপাদন ব্যবস্থাপনা ও বিপণন—সব বিষয় অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, MCQ ও CQ প্র্যাকটিসসহ পড়ানো হবে। NCTB এর সর্বশেষ সিলেবাস ও বোর্ড প্রশ্নপ্যাটার্ন অনুসরণ করে তৈরি এই কোর্সটি বোর্ড পরীক্ষায় ভালো ফলাফল ও শক্ত বেসিক তৈরির জন্য বিশেষভাবে সাজানো। বাংলাদেশের শিক্ষার্থীদের জন্য ঘরে বসে নির্ভরযোগ্য অনলাইন প্রস্তুতি।',
                'meta_title' => 'ক্লাস ১১ ব্যবসায় শিক্ষা কোর্স HSC ২০২৭ | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'HSC ২০২৭ ক্লাস ১১ ব্যবসায় শিক্ষা অনলাইন কোর্স। হিসাববিজ্ঞান, ফিন্যান্স, ব্যবস্থাপনা ও বিপণন—ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে।',
                'meta_keywords' => 'HSC 2027 Business Studies, Class 11 ব্যবসায় শিক্ষা, HSC ব্যবসায় শিক্ষা কোর্স, হিসাববিজ্ঞান ক্লাস ১১, ফিন্যান্স ও ব্যাংকিং HSC, Business Studies Online Course Bangladesh',
                'canonical_url' => 'class-11-hsc-2027-business-studies-course',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/class-11-hsc-2027-business.webp',
            ],
            [
                'title' => 'HSC ২০২৬ Extra Care Batch | বিশেষ কোচিং ও সম্পূর্ণ প্রস্তুতি',
                'slug' => Str::slug('hsc-2026-extra-care-batch-bangladesh'),
                'overview' => 'HSC ২০২৬ পরীক্ষার্থীদের জন্য বিশেষভাবে ডিজাইন করা Extra Care Batch। যারা নিয়মিত ক্লাসে পিছিয়ে পড়ছে বা একদম শুরু থেকে কনসেপ্ট ক্লিয়ার করতে চায়—তাদের জন্য এই ব্যাচে থাকবে ছোট ব্যাচ সাইজ, আলাদা মেন্টর সাপোর্ট, ধাপে ধাপে সিলেবাস কভারেজ, অতিরিক্ত লাইভ ক্লাস, ডেইলি প্র্যাকটিস, সাপ্তাহিক টেস্ট ও পার্সোনাল ফিডব্যাক। বিজ্ঞান ও ব্যবসায় শিক্ষা উভয় বিভাগের শিক্ষার্থীদের জন্য উপযোগী এই ব্যাচটি নিশ্চিত প্রস্তুতির মাধ্যমে ভালো ফলাফল অর্জনে সহায়তা করবে।',
                'meta_title' => 'HSC ২০২৬ Extra Care Batch | বিশেষ কোচিং বাংলাদেশ',
                'meta_description' => 'HSC ২০২৬ Extra Care Batch। দুর্বল শিক্ষার্থীদের জন্য বিশেষ সাপোর্ট, ছোট ব্যাচ, লাইভ ক্লাস, নিয়মিত টেস্ট ও পার্সোনাল মেন্টরিং। এখনই ভর্তি হও।',
                'meta_keywords' => 'HSC 2026 Extra Care Batch, HSC Special Batch, HSC দুর্বল শিক্ষার্থী ব্যাচ, HSC কোচিং বাংলাদেশ, HSC 2026 বিশেষ প্রস্তুতি',
                'canonical_url' => 'hsc-2026-extra-care-batch',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/extra-care-2026.webp',
            ],
            [
                'title' => 'ক্লাস ১১ মানবিক কোর্স | HSC ২০২৭ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-11-hsc-2027-humanities-online-course-bangladesh'),
                'overview' => 'ক্লাস ১১ মানবিক বিভাগের শিক্ষার্থীদের জন্য সম্পূর্ণ HSC ২০২৭ অনলাইন কোর্স। বাংলা, ইংরেজি, ইতিহাস, ইসলাম শিক্ষা/নৈতিক শিক্ষা, যুক্তিবিদ্যা, সমাজবিজ্ঞান ও অর্থনীতি—সব বিষয় অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, MCQ ও CQ প্র্যাকটিসসহ পড়ানো হবে। NCTB এর সর্বশেষ সিলেবাস ও বোর্ড প্রশ্নপ্যাটার্ন অনুসরণ করে তৈরি এই কোর্সটি মানবিক বিভাগের শিক্ষার্থীদের জন্য শক্ত বেসিক ও ভালো ফলাফলের নিশ্চয়তা দেয়।',
                'meta_title' => 'ক্লাস ১১ মানবিক কোর্স HSC ২০২৭ | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'HSC ২০২৭ ক্লাস ১১ মানবিক অনলাইন কোর্স। বাংলা, ইংরেজি, ইতিহাস, সমাজবিজ্ঞান ও অর্থনীতি—ভিডিও লেকচার, নোট ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে।',
                'meta_keywords' => 'HSC 2027 Humanities, Class 11 মানবিক, HSC মানবিক কোর্স, ক্লাস ১১ মানবিক অনলাইন প্রস্তুতি, Humanities Course Bangladesh',
                'canonical_url' => 'class-11-hsc-2027-humanities-course',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/class-11-hsc-2027-humanities.webp',
            ],
            [
                'title' => 'ক্লাস ১১ মানবিক কোর্স | HSC ২০২৬ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-11-hsc-2026-humanities-online-course-bangladesh'),
                'overview' => 'ক্লাস ১১ মানবিক বিভাগের শিক্ষার্থীদের জন্য সম্পূর্ণ HSC ২০২৬ অনলাইন কোর্স। বাংলা, ইংরেজি, ইতিহাস, ইসলাম শিক্ষা/নৈতিক শিক্ষা, যুক্তিবিদ্যা, সমাজবিজ্ঞান ও অর্থনীতি—সব বিষয় অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, MCQ ও CQ প্র্যাকটিসসহ পড়ানো হবে। NCTB এর সর্বশেষ সিলেবাস ও বোর্ড প্রশ্নপ্যাটার্ন অনুসরণ করে তৈরি এই কোর্সটি মানবিক বিভাগের শিক্ষার্থীদের কনসেপ্ট ক্লিয়ার করে বোর্ড পরীক্ষায় ভালো ফলাফল অর্জনে সহায়তা করবে।',
                'meta_title' => 'ক্লাস ১১ মানবিক কোর্স HSC ২০২৬ | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'HSC ২০২৬ ক্লাস ১১ মানবিক অনলাইন কোর্স। বাংলা, ইংরেজি, ইতিহাস, সমাজবিজ্ঞান ও অর্থনীতি—ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে।',
                'meta_keywords' => 'HSC 2026 Humanities, Class 11 মানবিক, HSC মানবিক কোর্স, ক্লাস ১১ মানবিক অনলাইন প্রস্তুতি, Humanities Course Bangladesh',
                'canonical_url' => 'class-11-hsc-2026-humanities-course',
                'base_price' => 9990,
                'price' => 7500,
                'cover' => 'covers/class-11-hsc-2026-humanities.webp',
            ],
            [
                'title' => 'SSC Arts English, Math & ICT কোর্স | সম্পূর্ণ অনলাইন প্রস্তুতি',
                'slug' => Str::slug('ssc-arts-english-math-ict-online-course-bangladesh'),
                'overview' => 'SSC মানবিক (Arts) বিভাগের শিক্ষার্থীদের জন্য বিশেষভাবে সাজানো English, General Math ও ICT সম্পূর্ণ অনলাইন কোর্স। বোর্ড পরীক্ষার সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ ব্যাখ্যা, নোট, MCQ ও সৃজনশীল প্রশ্ন প্র্যাকটিসের মাধ্যমে শিক্ষার্থীদের বেসিক থেকে পরীক্ষাভিত্তিক প্রস্তুতি নিশ্চিত করা হয়। যারা এই তিনটি বিষয়ে দুর্বল, তাদের জন্য কনসেপ্ট ক্লিয়ার ও ভালো ফলাফল অর্জনের নির্ভরযোগ্য সমাধান।',
                'meta_title' => 'SSC Arts English Math ICT কোর্স | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'SSC (Arts) শিক্ষার্থীদের জন্য English, General Math ও ICT অনলাইন কোর্স। ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে।',
                'meta_keywords' => 'SSC Arts English Math ICT, SSC মানবিক কোর্স, SSC English Math ICT Online, SSC Arts Preparation Bangladesh',
                'canonical_url' => 'ssc-arts-english-math-ict-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/ssc-arts-english-math-ict.webp',
            ],
            [
                'title' => 'Class 6 English, Math & ICT কোর্স | অনলাইন বেসিক প্রস্তুতি',
                'slug' => Str::slug('class-6-english-math-ict-online-course-bangladesh'),
                'overview' => 'Class 6 শিক্ষার্থীদের জন্য English, Mathematics ও ICT বিষয়সমূহের একটি সম্পূর্ণ অনলাইন কোর্স। নতুন সিলেবাস (NCTB) অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ উদাহরণ, ক্লাস নোট, অনুশীলনী ও কুইজের মাধ্যমে শিক্ষার্থীদের বেসিক শক্ত করা হয়। যারা শুরু থেকেই ইংরেজি, গণিত ও আইসিটিতে ভালো করতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'Class 6 English Math ICT কোর্স | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'Class 6 English, Math ও ICT অনলাইন কোর্স। বেসিক থেকে প্রস্তুতি, ভিডিও লেকচার, নোট ও অনুশীলনীসহ। বাংলাদেশ NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'Class 6 English Math ICT, Class 6 Online Course Bangladesh, Class Six English Math ICT, NCTB Class 6',
                'canonical_url' => 'class-6-english-math-ict-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/class-6-english-math-ict.webp',
            ],
            [
                'title' => 'Class 7 English, Math & ICT কোর্স | অনলাইন বেসিক প্রস্তুতি',
                'slug' => Str::slug('class-7-english-math-ict-online-course-bangladesh'),
                'overview' => 'Class 7 শিক্ষার্থীদের জন্য English, Mathematics ও ICT বিষয়সমূহের একটি সম্পূর্ণ অনলাইন কোর্স। NCTB সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, ক্লাস নোট, অনুশীলনী ও কুইজের মাধ্যমে শিক্ষার্থীদের বেসিক ও কনসেপ্ট শক্ত করা হয়। যারা শুরু থেকেই ইংরেজি, গণিত ও আইসিটিতে ভালো করতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'Class 7 English Math ICT কোর্স | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'Class 7 English, Math ও ICT অনলাইন কোর্স। বেসিক থেকে উন্নত পর্যায়ের প্রস্তুতি, ভিডিও লেকচার, নোট ও অনুশীলনীসহ। বাংলাদেশ NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'Class 7 English Math ICT, Class 7 Online Course Bangladesh, Class Seven English Math ICT, NCTB Class 7',
                'canonical_url' => 'class-7-english-math-ict-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/class-7-english-math-ict.webp',
            ],
            [
                'title' => 'Class 8 English, Math & ICT কোর্স | অনলাইন বেসিক প্রস্তুতি',
                'slug' => Str::slug('class-8-english-math-ict-online-course-bangladesh'),
                'overview' => 'Class 8 শিক্ষার্থীদের জন্য English, Mathematics ও ICT বিষয়সমূহের সম্পূর্ণ অনলাইন কোর্স। NCTB সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, অনুশীলনী ও কুইজের মাধ্যমে শিক্ষার্থীদের কনসেপ্ট শক্ত করা হয়। যারা ইংরেজি, গণিত ও আইসিটিতে আত্মবিশ্বাসী হতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'Class 8 English Math ICT কোর্স | অনলাইন প্রস্তুতি বাংলাদেশ',
                'meta_description' => 'Class 8 English, Math ও ICT অনলাইন কোর্স। বেসিক থেকে উন্নত পর্যায়ের প্রস্তুতি, ভিডিও লেকচার, নোট ও অনুশীলনীসহ। NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'Class 8 English Math ICT, Class 8 Online Course Bangladesh, Class Eight English Math ICT, NCTB Class 8',
                'canonical_url' => 'class-8-english-math-ict-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/class-8-english-math-ict.webp',
            ],
            [
                'title' => 'Class 9 Science - Physics, Chemistry, Biology & Higher Math | অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-9-science-physics-chemistry-biology-higher-math-online-course-bangladesh'),
                'overview' => 'Class 9 Science শিক্ষার্থীদের জন্য Physics, Chemistry, Biology এবং Higher Math বিষয়গুলোর সম্পূর্ণ অনলাইন কোর্স। NCTB সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, ক্লাস নোট, MCQ ও CQ প্র্যাকটিসের মাধ্যমে শিক্ষার্থীদের বেসিক এবং পরীক্ষাভিত্তিক প্রস্তুতি নিশ্চিত করা হয়। যারা বিজ্ঞান বিষয়ে শক্ত বেসিক ও কনসেপ্ট ক্লিয়ার করতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'Class 9 Science Course - Physics, Chemistry, Biology & Higher Math | Bangladesh Online Preparation',
                'meta_description' => 'Class 9 Science - Physics, Chemistry, Biology & Higher Math অনলাইন কোর্স। ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে। NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'Class 9 Science, Physics Chemistry Biology Higher Math, Class 9 Online Course Bangladesh, NCTB Science Class 9',
                'canonical_url' => 'class-9-science-phy-chem-bio-hmath-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/class-9-science-phy-chem-bio-hmath.webp',
            ],
            [
                'title' => 'Class 10 Science - Physics, Chemistry, Biology & Higher Math | অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-10-science-physics-chemistry-biology-higher-math-online-course-bangladesh'),
                'overview' => 'Class 10 Science শিক্ষার্থীদের জন্য Physics, Chemistry, Biology এবং Higher Math বিষয়গুলোর সম্পূর্ণ অনলাইন কোর্স। NCTB সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, ক্লাস নোট, MCQ ও CQ প্র্যাকটিসের মাধ্যমে শিক্ষার্থীদের কনসেপ্ট ক্লিয়ার ও পরীক্ষাভিত্তিক প্রস্তুতি নিশ্চিত করা হয়। যারা বিজ্ঞান বিষয়গুলিতে দৃঢ় বেসিক তৈরি করতে চায় এবং ভালো ফলাফল অর্জন করতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'Class 10 Science Course - Physics, Chemistry, Biology & Higher Math | Bangladesh Online Preparation',
                'meta_description' => 'Class 10 Science - Physics, Chemistry, Biology & Higher Math অনলাইন কোর্স। ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে। NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'Class 10 Science, Physics Chemistry Biology Higher Math, Class 10 Online Course Bangladesh, NCTB Science Class 10',
                'canonical_url' => 'class-10-science-phy-chem-bio-hmath-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/class-10-science-phy-chem-bio-hmath.webp',
            ],
            [
                'title' => 'Class 9 Commerce - Accounting, English, Math & ICT | অনলাইন প্রস্তুতি',
                'slug' => Str::slug('class-9-commerce-accounting-english-math-ict-online-course-bangladesh'),
                'overview' => 'Class 9 Commerce শিক্ষার্থীদের জন্য Accounting, English, Mathematics ও ICT বিষয়গুলোর সম্পূর্ণ অনলাইন কোর্স। NCTB সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, MCQ ও CQ প্র্যাকটিসের মাধ্যমে শিক্ষার্থীদের বেসিক থেকে পরীক্ষাভিত্তিক প্রস্তুতি নিশ্চিত করা হয়। যারা কমার্স বিষয়গুলিতে শক্ত বেসিক তৈরি করতে চায় এবং ভালো ফলাফল অর্জন করতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'Class 9 Commerce Course – Accounting, English, Math & ICT | Bangladesh Online Preparation',
                'meta_description' => 'Class 9 Commerce – Accounting, English, Math & ICT অনলাইন কোর্স। ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে। NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'Class 9 Commerce, Accounting, English, Math, ICT, Class 9 Online Course Bangladesh, NCTB Commerce Class 9',
                'canonical_url' => 'class-9-commerce-accounting-english-math-ict-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/class-9-commerce-accounting-english-math-ict.webp',
            ],
            [
                'title' => 'SSC Commerce – Accounting, English, Math & ICT | অনলাইন প্রস্তুতি',
                'slug' => Str::slug('ssc-commerce-accounting-english-math-ict-online-course-bangladesh'),
                'overview' => 'SSC Commerce শিক্ষার্থীদের জন্য Accounting, English, Mathematics ও ICT বিষয়গুলোর সম্পূর্ণ অনলাইন কোর্স। NCTB সিলেবাস অনুযায়ী অধ্যায়ভিত্তিক ভিডিও লেকচার, সহজ নোট, MCQ ও CQ প্র্যাকটিসের মাধ্যমে শিক্ষার্থীদের বেসিক থেকে পরীক্ষাভিত্তিক প্রস্তুতি নিশ্চিত করা হয়। যারা কমার্স বিষয়গুলিতে আত্মবিশ্বাসী হতে চায় এবং ভালো ফলাফল অর্জন করতে চায়—তাদের জন্য এই কোর্সটি আদর্শ।',
                'meta_title' => 'SSC Commerce Course – Accounting, English, Math & ICT | Bangladesh Online Preparation',
                'meta_description' => 'SSC Commerce – Accounting, English, Math & ICT অনলাইন কোর্স। ভিডিও লেকচার, নোট, MCQ ও বোর্ড প্রস্তুতি এক প্ল্যাটফর্মে। NCTB সিলেবাস অনুযায়ী।',
                'meta_keywords' => 'SSC Commerce, Accounting, English, Math, ICT, SSC Online Course Bangladesh, NCTB Commerce SSC',
                'canonical_url' => 'ssc-commerce-accounting-english-math-ict-course',
                'base_price' => 9990,
                'price' => 2990,
                'cover' => 'covers/ssc-commerce-accounting-english-math-ict.webp',
            ],
        ];



        foreach ($courses as $course) {
            Course::query()->create(array_merge($course, [
                'user_id' => fake()->randomElement(User::query()->pluck('id')->toArray()),
                'category_id' => fake()->randomElement(
                    Category::query()->whereNotNull('parent_id')->pluck('id')->toArray()
                ),
                'subcategory_id' => fake()->randomElement(Category::query()->pluck('id')->toArray()),
                'collection_id' => fake()->randomElement(Collection::query()->pluck('id')->toArray()),

                'description' => 'This course includes detailed lessons, exercises, and real-world applications for better understanding.',

                'access_days'   => 365,
                'level' => CourseLevel::BEGINNER,
                'is_feature' => fake()->randomElement([true, false]),
                'status' => CourseStatus::PUBLISHED,
            ]));
        }
    }
}
