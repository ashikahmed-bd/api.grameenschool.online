<?php

namespace Database\Seeders;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use App\Enums\LectureType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Course;
use App\Models\CourseInstructor;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Section;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $course = Course::query()->create([
            'user_id'        => User::query()->inRandomOrder()->value('id'),
            'category_id'    => Category::query()->inRandomOrder()->value('id'),
            'subcategory_id' => Category::query()->inRandomOrder()->value('id'),
            'collection_id'  => Collection::query()->inRandomOrder()->value('id'),

            'title' => 'Microsoft PowerPoint Masterclass',
            'slug'  => 'microsoft-powerpoint-masterclass',

            'overview' => 'এই কোর্সটির মাধ্যমে আপনি শিখবেন কীভাবে প্রফেশনাল ও প্রেজেন্টেবল Microsoft PowerPoint স্লাইড তৈরি করতে হয়।
একাডেমিক প্রেজেন্টেশন, অফিসিয়াল মিটিং কিংবা কর্পোরেট প্রেজেন্টেশনের জন্য আকর্ষণীয় ও কার্যকর স্লাইড ডিজাইন করার পূর্ণ গাইডলাইন পাবেন।',

            'description' =>
            '- স্কুল, কলেজ ও বিশ্ববিদ্যালয়ের শিক্ষার্থীরা যারা প্রেজেন্টেশনে দক্ষ হতে চান
- চাকরিজীবী যারা অফিস মিটিং ও রিপোর্ট প্রেজেন্টেশনে দক্ষতা বাড়াতে চান
- ফ্রিল্যান্সার ও কনটেন্ট ক্রিয়েটর যারা ক্লায়েন্টের জন্য প্রেজেন্টেশন তৈরি করতে চান
- শিক্ষক, ট্রেইনার ও কর্পোরেট প্রফেশনাল
- যেকোনো বয়সের মানুষ যারা PowerPoint-এ এক্সপার্ট হতে চান',

            'meta_title'       => 'Microsoft PowerPoint Masterclass',
            'meta_description' => 'PowerPoint Masterclass কোর্সের মাধ্যমে প্রফেশনাল স্লাইড ডিজাইন ও প্রেজেন্টেশন স্কিল অর্জন করুন।',
            'meta_keywords'    => 'PowerPoint, Presentation, Microsoft PowerPoint Course',
            'canonical_url'    => '',

            'base_price' => 5000,
            'price'      => 3000,

            'access_days'   => null,
            'level'      => CourseLevel::BEGINNER,
            'is_feature' => fake()->boolean(),
            'cover'    => 'covers/power-point.webp',
            'intro_id' => 'YE7VzlLtp-4',
            'status' => CourseStatus::PUBLISHED,

            'learnings' => [
                'Microsoft PowerPoint এর ইন্টারফেস ও প্রয়োজনীয় টুলসমূহ সম্পর্কে পূর্ণ ধারণা',
                'প্রফেশনাল স্লাইড ডিজাইন ও লেআউট তৈরি করার কৌশল',
                'চার্ট, গ্রাফ, ইনফোগ্রাফিক ও অ্যানিমেশন ব্যবহার',
                'কর্পোরেট ও একাডেমিক প্রেজেন্টেশন তৈরি',
                'রিয়েল-লাইফ প্রেজেন্টেশন প্রজেক্ট তৈরি ও প্র্যাকটিস',
            ],

            'requirements' => [
                'ইন্টারনেট সংযোগ (ওয়াইফাই বা মোবাইল ডাটা)',
                'ল্যাপটপ অথবা ডেস্কটপ কম্পিউটার',
                'Microsoft PowerPoint (2019 বা তার উপরে)',
                'শিখবার আগ্রহ ও নিয়মিত প্র্যাকটিস করার মানসিকতা',
            ],

            'includes' => [
                'আজীবন কোর্স অ্যাক্সেস',
                'স্টেপ-বাই-স্টেপ ভিডিও লেসন',
                'প্র্যাকটিস ফাইল ও রিসোর্স',
                'প্রফেশনাল প্রেজেন্টেশন টেমপ্লেট',
                'কোর্স শেষে সার্টিফিকেট',
            ],
        ]);



        $sections = [
            [
                'title' => 'Getting Started',
                'lectures' => [
                    [
                        'hashid' => 'V3Mr2ABj6P',
                        'title' => 'Introduction to PowerPoint',
                        'type'  => LectureType::VIDEO,
                        'body' => 'এই লেকচারে PowerPoint এর বেসিক ধারণা ও ব্যবহার শেখানো হবে।',
                        'duration' => 0.95,
                    ],
                    [
                        'title' => 'PowerPoint Interface Overview',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে PowerPoint এর বিভিন্ন মেনু, রিবন এবং টুলবার সম্পর্কে বিস্তারিত আলোচনা করা হবে।',
                        'duration' => 1.10,
                    ],
                    [
                        'title' => 'Creating Your First Slide',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে নতুন স্লাইড তৈরি করা, লেআউট নির্বাচন এবং কনটেন্ট যোগ করার পদ্ধতি শেখানো হবে।',
                        'duration' => 1.05,
                    ],
                    [
                        'title' => 'Working with Text & Images',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে টেক্সট ফরম্যাটিং, ছবি যোগ করা এবং স্লাইডকে সুন্দরভাবে সাজানোর কৌশল শেখানো হবে।',
                        'duration' => 1.15,
                    ],
                    [
                        'title' => 'Saving & Managing Presentations',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে প্রেজেন্টেশন সংরক্ষণ, ফাইল ম্যানেজমেন্ট এবং বিভিন্ন ফরম্যাটে সেভ করার নিয়ম শেখানো হবে।',
                        'duration' => 0.90,
                    ],
                ],
            ],
            [
                'title' => 'Interface & Tools',
                'lectures' => [
                    [
                        'title' => 'PowerPoint Interface Overview',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে PowerPoint এর interface ও গুরুত্বপূর্ণ tools পরিচিতি দেওয়া হবে।',
                        'duration' => 1.20,
                    ],
                    [
                        'title' => 'Ribbon, Menu & Toolbar Explained',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে PowerPoint এর ribbon, menu এবং toolbar কীভাবে কাজ করে তা বিস্তারিতভাবে ব্যাখ্যা করা হবে।',
                        'duration' => 1.10,
                    ],
                    [
                        'title' => 'Using Quick Access Toolbar',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে Quick Access Toolbar কাস্টমাইজ করা এবং দ্রুত কাজ করার কৌশল শেখানো হবে।',
                        'duration' => 0.95,
                    ],
                    [
                        'title' => 'View Modes & Navigation Tools',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে বিভিন্ন view mode, slide navigator এবং zoom tools ব্যবহারের নিয়ম শেখানো হবে।',
                        'duration' => 1.05,
                    ],
                ],
            ],
            [
                'title' => 'Working with Slides',
                'lectures' => [
                    [
                        'title' => 'Creating & Managing Slides',
                        'type'  => LectureType::TEXT,
                        'body' => 'Slide তৈরি, edit ও organize করার পদ্ধতি শেখানো হবে।',
                        'duration' => 1.10,
                    ],
                    [
                        'title' => 'Adding & Deleting Slides',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে নতুন slide যোগ করা, অপ্রয়োজনীয় slide মুছে ফেলা এবং slide structure ঠিক রাখার কৌশল শেখানো হবে।',
                        'duration' => 0.95,
                    ],
                    [
                        'title' => 'Slide Layouts & Placeholders',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে বিভিন্ন slide layout, placeholder ব্যবহার এবং কনটেন্ট সঠিকভাবে বসানোর নিয়ম শেখানো হবে।',
                        'duration' => 1.05,
                    ],
                    [
                        'title' => 'Reordering & Grouping Slides',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে slide reorder করা, group করা এবং presentation flow সুন্দর করার কৌশল শেখানো হবে।',
                        'duration' => 1.00,
                    ],
                ],
            ],
            [
                'title' => 'Design & Animation',
                'lectures' => [
                    [
                        'title' => 'Design, Theme & Animation',
                        'type'  => LectureType::TEXT,
                        'body' => 'Presentation সুন্দর করার জন্য design, theme ও animation ব্যবহার শেখানো হবে।',
                        'duration' => 1.35,
                    ],
                    [
                        'title' => 'Using Built-in Themes & Templates',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে PowerPoint এর built-in themes ও templates ব্যবহার করে দ্রুত আকর্ষণীয় presentation তৈরি করার পদ্ধতি শেখানো হবে।',
                        'duration' => 1.10,
                    ],
                    [
                        'title' => 'Custom Design & Slide Background',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে custom design তৈরি করা, background color, image ও gradient ব্যবহার শেখানো হবে।',
                        'duration' => 1.20,
                    ],
                    [
                        'title' => 'Applying Animations & Transitions',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে slide animation ও transition সঠিকভাবে প্রয়োগ করে presentation কে আরও engaging করার কৌশল শেখানো হবে।',
                        'duration' => 1.25,
                    ],
                ],
            ],
            [
                'title' => 'Export & Presentation',
                'lectures' => [
                    [
                        'title' => 'Exporting & Presenting Slides',
                        'type'  => LectureType::TEXT,
                        'body' => 'Presentation export করা এবং live presentation দেওয়ার কৌশল শেখানো হবে।',
                        'duration' => 0.85,
                    ],
                    [
                        'title' => 'Saving in Different Formats',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে PowerPoint প্রেজেন্টেশনকে বিভিন্ন ফরম্যাটে (PDF, PPTX, Video) সংরক্ষণ করার নিয়ম শেখানো হবে।',
                        'duration' => 0.95,
                    ],
                    [
                        'title' => 'Preparing for Live Presentation',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে live presentation দেওয়ার আগে slide review, rehearsal এবং projector setup-এর কৌশল শেখানো হবে।',
                        'duration' => 1.05,
                    ],
                    [
                        'title' => 'Tips & Best Practices',
                        'type'  => LectureType::TEXT,
                        'body' => 'এই লেকচারে presentation delivery-এর জন্য বিভিন্ন tips, shortcuts এবং best practices শেখানো হবে।',
                        'duration' => 1.00,
                    ],
                ],
            ],
        ];

        foreach ($sections as $sectionIndex => $sectionData) {
            $section = Section::query()->create([
                'course_id'  => $course->id,
                'title'      => $sectionData['title'],
                'sort_order' => $sectionIndex + 1,
            ]);

            foreach ($sectionData['lectures'] as $lectureIndex => $lectureData) {
                Lecture::query()->create([
                    'course_id'  => $course->id,
                    'section_id' => $section->id,
                    'title'      => $lectureData['title'],
                    'type'      => $lectureData['type'],
                    'body'       => $lectureData['body'],
                    'duration'   => $lectureData['duration'],
                    'sort_order' => $lectureIndex + 1,
                ]);
            }
        }


        Video::create([
            'lecture_id' => 1,
            'title' => "Big Buck Bunny",
            'video_id' => "YE7VzlLtp-4",
            'provider' => "youtube",

        ]);


        $instructors = User::query()->where('role', UserRole::INSTRUCTOR->value)->take(4)->get();

        foreach ($instructors as $instructor) {
            CourseInstructor::query()->create([
                'course_id'     => $course->id,
                'user_id' => $instructor->id,
            ]);
        }

        $student = User::query()
            ->where('role', UserRole::STUDENT->value)
            ->first();

        $order = Order::create([
            'user_id'       => $student->id,
            'invoice_id'    => 'INV-' . time(),
            'subtotal'      => $course->price,
            'discount'      => 0,
            'total'         => $course->price,
            'paid_amount'   => 0,
            'due_amount'    => $course->price,
            'payment_method' => PaymentMethod::BKASH,
            'status'        => OrderStatus::PARTIAL,
        ]);

        OrderItem::create([
            'order_id'  => $order->id,
            'course_id' => $course->id,
            'price'     => $course->price,
            'quantity'  => 1,
            'total'     => $course->price * 1,
        ]);

        Payment::create([
            'user_id'  => $order->user_id,
            'order_id' => $order->id,
            'invoice_id' => $order->invoice_id,
            'amount'   => $course->price,
            'status'   => PaymentStatus::SUCCESS,
            'paid_at'  => now(),
        ]);

        Enrollment::query()->create([
            'course_id' => $course->id,
            'user_id' => $student->id,
            'order_id' => $order->id,
            'progress' => 0,
            'status'   => EnrollmentStatus::ONGOING,
            'enrolled_at' => now(),
        ]);

        $reviews = [
            [
                'user_id' => 1,
                'name' => 'সাবিহা আক্তার',
                'designation' => 'এইচএসসি শিক্ষার্থী, ঢাকা',
                'comment' => 'এই প্ল্যাটফর্ম থেকে আমি যেভাবে গাইডলাইন পেয়েছি, তা আমার জীবনের মোড় ঘুরিয়ে দিয়েছে।',
                'rating' => 5,
            ],
            [
                'user_id' => 2,
                'name' => 'রাফসান জামান',
                'designation' => 'ব্যাচেলর স্টুডেন্ট, চট্টগ্রাম',
                'comment' => 'ইংলিশ কোর্সটা একদম প্র্যাকটিকাল। এখন আমি আত্মবিশ্বাসের সাথে কথা বলতে পারি।',
                'rating' => 4,
            ],
            [
                'user_id' => 3,
                'name' => 'তাসনিম রাইসা',
                'designation' => 'স্কুল শিক্ষার্থী',
                'comment' => 'অ্যাকাডেমিক ভিডিও কনটেন্টগুলো অনেক হেল্পফুল, সহজ ভাষায় সব বুঝি।',
                'rating' => 5,
            ],
        ];

        foreach ($reviews as $review) {
            $course->reviews()->create($review);
        }
    }
}
