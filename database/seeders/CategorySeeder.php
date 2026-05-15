<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'ক্লাস ৬–১০',
                'slug' => 'class-6-10',
                'icon' => '/categories/academic.png',
                'description' => 'ষষ্ঠ থেকে দশম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, ইংরেজি, গণিত, বিজ্ঞান, আইসিটি ও অন্যান্য সকল বিষয়ের পূর্ণাঙ্গ অনলাইন কোর্স, লাইভ ক্লাস, নোট ও পরীক্ষার প্রস্তুতি।',
                'meta_title' => 'ক্লাস ৬–১০ অনলাইন কোর্স | ষষ্ঠ–দশম শ্রেণির সকল বিষয়',
                'meta_description' => 'ষষ্ঠ থেকে দশম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, ইংরেজি, গণিত, বিজ্ঞান, আইসিটি ও বোর্ড পরীক্ষার প্রস্তুতির সেরা অনলাইন কোর্স।',
                'meta_keywords' => 'ক্লাস ৬, ক্লাস ৭, ক্লাস ৮, ক্লাস ৯, ক্লাস ১০, SSC কোর্স, অনলাইন শিক্ষা, গণিত, বিজ্ঞান',
                'canonical_url' => '/categories/class-6-10',
                'sort_order' => 1,

                'children' => [

                    [
                        'name' => 'ষষ্ঠ শ্রেণি',
                        'slug' => 'class-6',
                        'icon' => '/categories/six.png',
                        'sort_order' => 1,
                        'description' => 'ষষ্ঠ শ্রেণির শিক্ষার্থীদের জন্য বাংলা, ইংরেজি, গণিত, বিজ্ঞান ও সকল বিষয়ের বোর্ডভিত্তিক অনলাইন কোর্স।',
                        'meta_title' => 'ষষ্ঠ শ্রেণি অনলাইন কোর্স | Class 6 সকল বিষয়',
                        'meta_description' => 'ষষ্ঠ শ্রেণির জন্য বাংলা, ইংরেজি, গণিত, বিজ্ঞান ও অন্যান্য বিষয়ের পূর্ণাঙ্গ ভিডিও কোর্স ও লাইভ ক্লাস।',
                        'meta_keywords' => 'ষষ্ঠ শ্রেণি, class 6, class six, ষষ্ঠ শ্রেণি কোর্স',
                        'canonical_url' => '/categories/class-6-10/class-6',
                    ],

                    [
                        'name' => 'সপ্তম শ্রেণি',
                        'slug' => 'class-7',
                        'icon' => '/categories/seven.png',
                        'sort_order' => 2,
                        'description' => 'সপ্তম শ্রেণির শিক্ষার্থীদের জন্য বোর্ডভিত্তিক পূর্ণাঙ্গ অনলাইন কোর্স ও পরীক্ষার প্রস্তুতি।',
                        'meta_title' => 'সপ্তম শ্রেণি অনলাইন কোর্স | Class 7 সকল বিষয়',
                        'meta_description' => 'সপ্তম শ্রেণির বাংলা, ইংরেজি, গণিত, বিজ্ঞান ও অন্যান্য বিষয়ের ভিডিও কোর্স ও নোট।',
                        'meta_keywords' => 'সপ্তম শ্রেণি, class 7, class seven, class 7 course',
                        'canonical_url' => '/categories/class-6-10/class-7',
                    ],

                    [
                        'name' => 'অষ্টম শ্রেণি',
                        'slug' => 'class-8',
                        'icon' => '/categories/eight.png',
                        'sort_order' => 3,
                        'description' => 'অষ্টম শ্রেণির শিক্ষার্থীদের জন্য বোর্ডভিত্তিক সকল বিষয়ের ভিডিও ক্লাস, লাইভ ক্লাস ও মডেল টেস্ট।',
                        'meta_title' => 'অষ্টম শ্রেণি অনলাইন কোর্স | Class 8 Course',
                        'meta_description' => 'অষ্টম শ্রেণির বাংলা, ইংরেজি, গণিত, বিজ্ঞান ও আইসিটি বিষয়ের সম্পূর্ণ কোর্স।',
                        'meta_keywords' => 'অষ্টম শ্রেণি, class 8, JSC preparation, class 8 online course',
                        'canonical_url' => '/categories/class-6-10/class-8',
                    ],

                    [
                        'name' => 'নবম-দশম',
                        'slug' => 'class-9-10',
                        'icon' => '/categories/ssc.png',
                        'sort_order' => 4,
                        'description' => 'নবম ও দশম শ্রেণির বিজ্ঞান, ব্যবসায় শিক্ষা ও মানবিক বিভাগের শিক্ষার্থীদের জন্য SSC প্রস্তুতির পূর্ণাঙ্গ কোর্স।',
                        'meta_title' => 'নবম-দশম SSC অনলাইন কোর্স | সকল বিভাগ',
                        'meta_description' => 'SSC বিজ্ঞান, ব্যবসায় শিক্ষা ও মানবিক বিভাগের জন্য পূর্ণাঙ্গ অনলাইন কোর্স, লাইভ ক্লাস ও পরীক্ষা প্রস্তুতি।',
                        'meta_keywords' => 'SSC course, class 9, class 10, SSC science, SSC commerce, SSC arts',
                        'canonical_url' => '/categories/class-6-10/class-9-10',

                        'children' => [

                            [
                                'name' => 'বিজ্ঞান',
                                'slug' => 'science',
                                'icon' => '',
                                'sort_order' => 1,
                                'description' => 'SSC বিজ্ঞান বিভাগের শিক্ষার্থীদের জন্য গণিত, পদার্থবিজ্ঞান, রসায়ন ও জীববিজ্ঞানের পূর্ণাঙ্গ কোর্স।',
                                'meta_title' => 'SSC বিজ্ঞান বিভাগ অনলাইন কোর্স',
                                'meta_description' => 'SSC বিজ্ঞান বিভাগের গণিত, পদার্থ, রসায়ন, জীববিজ্ঞান ও আইসিটি বিষয়ের সেরা অনলাইন কোর্স।',
                                'meta_keywords' => 'SSC science, physics, chemistry, biology, math',
                                'canonical_url' => '/categories/class-6-10/class-9-10/science',
                            ],

                            [
                                'name' => 'ব্যবসায় শিক্ষা',
                                'slug' => 'commerce',
                                'icon' => '',
                                'sort_order' => 2,
                                'description' => 'SSC ব্যবসায় শিক্ষা বিভাগের হিসাববিজ্ঞান, ফিন্যান্স ও ব্যবসায় উদ্যোগ বিষয়ের পূর্ণাঙ্গ কোর্স।',
                                'meta_title' => 'SSC ব্যবসায় শিক্ষা অনলাইন কোর্স',
                                'meta_description' => 'SSC ব্যবসায় শিক্ষা বিভাগের হিসাববিজ্ঞান, ফিন্যান্স, ব্যবসায় উদ্যোগ ও অন্যান্য বিষয়ের কোর্স।',
                                'meta_keywords' => 'SSC commerce, accounting, finance, business studies',
                                'canonical_url' => '/categories/class-6-10/class-9-10/commerce',
                            ],

                            [
                                'name' => 'মানবিক',
                                'slug' => 'arts',
                                'icon' => '',
                                'sort_order' => 3,
                                'description' => 'SSC মানবিক বিভাগের ইতিহাস, ভূগোল, পৌরনীতি ও অন্যান্য বিষয়ের পূর্ণাঙ্গ অনলাইন কোর্স।',
                                'meta_title' => 'SSC মানবিক বিভাগ অনলাইন কোর্স',
                                'meta_description' => 'SSC মানবিক বিভাগের ইতিহাস, ভূগোল, পৌরনীতি ও অর্থনীতি বিষয়ের ভিডিও কোর্স।',
                                'meta_keywords' => 'SSC arts, humanities, history, geography',
                                'canonical_url' => '/categories/class-6-10/class-9-10/arts',
                            ],
                        ],
                    ],
                ],
            ],


            [
                'name' => 'HSC একাডেমিক',
                'slug' => 'hsc-academic',
                'icon' => '/categories/hsc.svg',
                'description' => 'একাদশ ও দ্বাদশ শ্রেণির শিক্ষার্থীদের জন্য বিজ্ঞান, ব্যবসায় শিক্ষা ও মানবিক বিভাগের পূর্ণাঙ্গ অনলাইন কোর্স, লাইভ ক্লাস, এক্সাম প্রস্তুতি ও বোর্ডভিত্তিক শিক্ষা।',
                'meta_title' => 'HSC একাডেমিক অনলাইন কোর্স | বিজ্ঞান, ব্যবসায় শিক্ষা ও মানবিক',
                'meta_description' => 'HSC বিজ্ঞান, ব্যবসায় শিক্ষা ও মানবিক বিভাগের জন্য বোর্ডভিত্তিক অনলাইন কোর্স, লাইভ ক্লাস, নোট ও পরীক্ষার প্রস্তুতি।',
                'meta_keywords' => 'HSC, HSC online course, একাদশ, দ্বাদশ, HSC বিজ্ঞান, HSC ব্যবসায় শিক্ষা, HSC মানবিক',
                'canonical_url' => '/categories/hsc-academic',
                'sort_order' => 2,

                'children' => [

                    [
                        'name' => 'বিজ্ঞান',
                        'slug' => 'science',
                        'icon' => '/categories/science.png',
                        'sort_order' => 1,
                        'description' => 'HSC বিজ্ঞান বিভাগের শিক্ষার্থীদের জন্য পদার্থবিজ্ঞান, রসায়ন, উচ্চতর গণিত, জীববিজ্ঞান ও আইসিটি বিষয়ের পূর্ণাঙ্গ কোর্স।',
                        'meta_title' => 'HSC বিজ্ঞান বিভাগ অনলাইন কোর্স',
                        'meta_description' => 'HSC বিজ্ঞান বিভাগের পদার্থবিজ্ঞান, রসায়ন, উচ্চতর গণিত, জীববিজ্ঞান ও আইসিটি বিষয়ের ভিডিও কোর্স ও লাইভ ক্লাস।',
                        'meta_keywords' => 'HSC science, physics, chemistry, biology, higher math, ICT',
                        'canonical_url' => '/categories/hsc-academic/science',
                    ],

                    [
                        'name' => 'ব্যবসায় শিক্ষা',
                        'slug' => 'commerce',
                        'icon' => '/categories/commerce.png',
                        'sort_order' => 2,
                        'description' => 'HSC ব্যবসায় শিক্ষা বিভাগের হিসাববিজ্ঞান, ফিন্যান্স, ব্যবস্থাপনা ও ব্যবসায় সংগঠন বিষয়ের পূর্ণাঙ্গ কোর্স।',
                        'meta_title' => 'HSC ব্যবসায় শিক্ষা অনলাইন কোর্স',
                        'meta_description' => 'HSC ব্যবসায় শিক্ষা বিভাগের হিসাববিজ্ঞান, ফিন্যান্স, ব্যবস্থাপনা ও ব্যবসায় সংগঠন বিষয়ের কোর্স।',
                        'meta_keywords' => 'HSC commerce, accounting, finance, management',
                        'canonical_url' => '/categories/hsc-academic/commerce',
                    ],

                    [
                        'name' => 'মানবিক',
                        'slug' => 'arts',
                        'icon' => '/categories/arts.png',
                        'sort_order' => 3,
                        'description' => 'HSC মানবিক বিভাগের ইতিহাস, ইসলামের ইতিহাস, সমাজবিজ্ঞান, পৌরনীতি ও অর্থনীতি বিষয়ের পূর্ণাঙ্গ কোর্স।',
                        'meta_title' => 'HSC মানবিক বিভাগ অনলাইন কোর্স',
                        'meta_description' => 'HSC মানবিক বিভাগের ইতিহাস, সমাজবিজ্ঞান, পৌরনীতি, অর্থনীতি ও অন্যান্য বিষয়ের ভিডিও কোর্স।',
                        'meta_keywords' => 'HSC arts, humanities, sociology, civics, economics',
                        'canonical_url' => '/categories/hsc-academic/arts',
                    ],

                ],
            ],

            [
                'name' => 'ভর্তি প্রস্তুতি',
                'slug' => 'admission',
                'icon' => '/categories/admission.png',
                'description' => 'বিশ্ববিদ্যালয়, মেডিকেল ও ইঞ্জিনিয়ারিং ভর্তি পরীক্ষার্থীদের জন্য পূর্ণাঙ্গ অনলাইন কোর্স, লাইভ ক্লাস, প্রশ্নব্যাংক, মডেল টেস্ট ও ভর্তি প্রস্তুতি।',
                'meta_title' => 'ভর্তি প্রস্তুতি অনলাইন কোর্স | বিশ্ববিদ্যালয়, মেডিকেল ও ইঞ্জিনিয়ারিং',
                'meta_description' => 'বিশ্ববিদ্যালয়, মেডিকেল ও ইঞ্জিনিয়ারিং ভর্তি পরীক্ষার জন্য সেরা অনলাইন কোর্স, লাইভ ক্লাস ও মডেল টেস্ট।',
                'meta_keywords' => 'ভর্তি প্রস্তুতি, university admission, medical admission, engineering admission, model test',
                'canonical_url' => '/categories/admission',
                'sort_order' => 3,

                'children' => [

                    [
                        'name' => 'বিশ্ববিদ্যালয় ভর্তি',
                        'slug' => 'university',
                        'icon' => '/categories/university.png',
                        'sort_order' => 1,
                        'description' => 'ঢাকা বিশ্ববিদ্যালয়, রাজশাহী বিশ্ববিদ্যালয়, জাহাঙ্গীরনগরসহ বিভিন্ন বিশ্ববিদ্যালয়ের ভর্তি পরীক্ষার পূর্ণাঙ্গ প্রস্তুতি কোর্স।',
                        'meta_title' => 'বিশ্ববিদ্যালয় ভর্তি প্রস্তুতি কোর্স',
                        'meta_description' => 'বিশ্ববিদ্যালয় ভর্তি পরীক্ষার জন্য বাংলা, ইংরেজি, সাধারণ জ্ঞান ও বিষয়ভিত্তিক পূর্ণাঙ্গ প্রস্তুতি।',
                        'meta_keywords' => 'university admission, DU admission, varsity admission',
                        'canonical_url' => '/categories/admission/university',
                    ],

                    [
                        'name' => 'মেডিকেল ভর্তি',
                        'slug' => 'medical',
                        'icon' => '/categories/medical.png',
                        'sort_order' => 2,
                        'description' => 'মেডিকেল ও ডেন্টাল ভর্তি পরীক্ষার্থীদের জন্য জীববিজ্ঞান, রসায়ন, পদার্থবিজ্ঞান ও ইংরেজির পূর্ণাঙ্গ কোর্স।',
                        'meta_title' => 'মেডিকেল ভর্তি প্রস্তুতি কোর্স',
                        'meta_description' => 'মেডিকেল ভর্তি পরীক্ষার জন্য biology, chemistry, physics ও english এর সম্পূর্ণ প্রস্তুতি কোর্স।',
                        'meta_keywords' => 'medical admission, dental admission, biology, chemistry',
                        'canonical_url' => '/categories/admission/medical',
                    ],

                    [
                        'name' => 'ইঞ্জিনিয়ারিং ভর্তি',
                        'slug' => 'engineering',
                        'icon' => '/categories/engineering.png',
                        'sort_order' => 3,
                        'description' => 'BUET, RUET, KUET, CUET ও অন্যান্য ইঞ্জিনিয়ারিং বিশ্ববিদ্যালয়ের ভর্তি পরীক্ষার পূর্ণাঙ্গ কোর্স।',
                        'meta_title' => 'ইঞ্জিনিয়ারিং ভর্তি প্রস্তুতি কোর্স',
                        'meta_description' => 'ইঞ্জিনিয়ারিং ভর্তি পরীক্ষার জন্য গণিত, পদার্থবিজ্ঞান, রসায়ন ও আইসিটি বিষয়ের প্রস্তুতি।',
                        'meta_keywords' => 'engineering admission, BUET admission, math, physics',
                        'canonical_url' => '/categories/admission/engineering',
                    ],

                ],
            ],

            [
                'name' => 'স্কিলস',
                'slug' => 'skills',
                'icon' => '/categories/skills.png',
                'description' => 'ক্যারিয়ার ও ফ্রিল্যান্সিংয়ের জন্য ওয়েব ডেভেলপমেন্ট, স্পোকেন ইংলিশ, ডিজিটাল মার্কেটিংসহ আধুনিক স্কিল ডেভেলপমেন্ট কোর্সসমূহ।',
                'meta_title' => 'স্কিল ডেভেলপমেন্ট অনলাইন কোর্স | Web Development, English, Marketing',
                'meta_description' => 'ওয়েব ডেভেলপমেন্ট, স্পোকেন ইংলিশ, ডিজিটাল মার্কেটিং ও ফ্রিল্যান্সিংয়ের জন্য সেরা অনলাইন স্কিল কোর্স।',
                'meta_keywords' => 'skills course, web development, spoken english, digital marketing, freelancing',
                'canonical_url' => '/categories/skills',
                'sort_order' => 4,

                'children' => [

                    [
                        'name' => 'ওয়েব ডেভেলপমেন্ট',
                        'slug' => 'web-development',
                        'icon' => '/categories/web-development.png',
                        'sort_order' => 1,
                        'description' => 'Laravel, PHP, Vue.js, Nuxt, JavaScript ও Full Stack Development শেখার জন্য প্রজেক্টভিত্তিক কোর্স।',
                        'meta_title' => 'ওয়েব ডেভেলপমেন্ট অনলাইন কোর্স',
                        'meta_description' => 'PHP, Laravel, Vue.js, JavaScript ও Full Stack Web Development শেখার সেরা অনলাইন কোর্স।',
                        'meta_keywords' => 'web development, laravel, vue js, javascript, full stack',
                        'canonical_url' => '/categories/skills/web-development',
                    ],

                    [
                        'name' => 'স্পোকেন ইংলিশ',
                        'slug' => 'spoken-english',
                        'icon' => '/categories/speaking.png',
                        'sort_order' => 2,
                        'description' => 'দৈনন্দিন কথোপকথন, IELTS speaking ও professional communication এর জন্য স্পোকেন ইংলিশ কোর্স।',
                        'meta_title' => 'স্পোকেন ইংলিশ অনলাইন কোর্স',
                        'meta_description' => 'Fluent spoken English, communication skills ও IELTS speaking এর জন্য পূর্ণাঙ্গ ইংলিশ কোর্স।',
                        'meta_keywords' => 'spoken english, english speaking, IELTS speaking, communication skills',
                        'canonical_url' => '/categories/skills/spoken-english',
                    ],

                    [
                        'name' => 'ডিজিটাল মার্কেটিং',
                        'slug' => 'digital-marketing',
                        'icon' => '/categories/digital-marketing.png',
                        'sort_order' => 3,
                        'description' => 'Facebook Marketing, SEO, YouTube Marketing, Content Marketing ও Freelancing ভিত্তিক ডিজিটাল মার্কেটিং কোর্স।',
                        'meta_title' => 'ডিজিটাল মার্কেটিং অনলাইন কোর্স',
                        'meta_description' => 'SEO, Facebook Marketing, YouTube Marketing ও Freelancing শেখার পূর্ণাঙ্গ ডিজিটাল মার্কেটিং কোর্স।',
                        'meta_keywords' => 'digital marketing, SEO, facebook marketing, youtube marketing, freelancing',
                        'canonical_url' => '/categories/skills/digital-marketing',
                    ],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $this->createCategory($category, null);
        }
    }

    private function createCategory(array $data, $parentId = null)
    {
        $children = $data['children'] ?? [];
        unset($data['children']);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'icon' => $data['icon'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'description' => $data['description'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keywords' => $data['meta_keywords'] ?? null,
            'canonical_url' => $data['canonical_url'] ?? null,
            'parent_id' => $parentId,
        ]);

        foreach ($children as $child) {
            $this->createCategory($child, $category->id);
        }

        return $category;
    }
}
