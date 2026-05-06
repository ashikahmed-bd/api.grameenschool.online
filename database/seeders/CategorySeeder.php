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
                'overview' => 'ষষ্ঠ থেকে দশম শ্রেণির শিক্ষার্থীদের জন্য সকল বিষয় অন্তর্ভুক্ত। গণিত, বিজ্ঞান, বাংলা, ইংরেজি ও অন্যান্য বিষয়গুলোর সম্পূর্ণ কোর্স।',
                'meta_title' => 'ক্লাস ৬–১০ কোর্সসমূহ',
                'meta_description' => 'ষষ্ঠ থেকে দশম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, ইংরেজি, গণিত, বিজ্ঞানসহ সকল বিষয়।',
                'meta_keywords' => 'ষষ্ঠ, সপ্তম, অষ্টম, নবম, দশম, ক্লাস কোর্স',
                'canonical_url' => null,
                'children' => [
                    [
                        'name' => 'ষষ্ঠ শ্রেণি',
                        'slug' => 'class-6',
                        'sort_order' => 1,
                        'overview' => 'ষষ্ঠ শ্রেণির শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স।',
                        'meta_title' => 'ষষ্ঠ শ্রেণি কোর্সসমূহ',
                        'meta_description' => 'ষষ্ঠ শ্রেণির শিক্ষার্থীদের জন্য বাংলা, গণিত, বিজ্ঞান সহ সকল বিষয়।',
                        'meta_keywords' => 'ষষ্ঠ, শ্রেণি, ক্লাস, কোর্স',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'সপ্তম শ্রেণি',
                        'slug' => 'class-7',
                        'sort_order' => 2,
                        'overview' => 'সপ্তম শ্রেণির শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স।',
                        'meta_title' => 'সপ্তম শ্রেণি কোর্সসমূহ',
                        'meta_description' => 'সপ্তম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, গণিত, বিজ্ঞান সহ সকল বিষয়।',
                        'meta_keywords' => 'সপ্তম, শ্রেণি, ক্লাস, কোর্স',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'অষ্টম শ্রেণি',
                        'slug' => 'class-8',
                        'sort_order' => 3,
                        'overview' => 'অষ্টম শ্রেণির শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স।',
                        'meta_title' => 'অষ্টম শ্রেণি কোর্সসমূহ',
                        'meta_description' => 'অষ্টম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, গণিত, বিজ্ঞান সহ সকল বিষয়।',
                        'meta_keywords' => 'অষ্টম, শ্রেণি, ক্লাস, কোর্স',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'নবম শ্রেণি',
                        'slug' => 'class-9',
                        'sort_order' => 4,
                        'overview' => 'নবম শ্রেণির শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স।',
                        'meta_title' => 'নবম শ্রেণি কোর্সসমূহ',
                        'meta_description' => 'নবম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, গণিত, বিজ্ঞান সহ সকল বিষয়।',
                        'meta_keywords' => 'নবম, শ্রেণি, ক্লাস, কোর্স',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'দশম শ্রেণি',
                        'slug' => 'class-10',
                        'sort_order' => 5,
                        'overview' => 'দশম শ্রেণির শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স।',
                        'meta_title' => 'দশম শ্রেণি কোর্সসমূহ',
                        'meta_description' => 'দশম শ্রেণির শিক্ষার্থীদের জন্য বাংলা, গণিত, বিজ্ঞান সহ সকল বিষয়।',
                        'meta_keywords' => 'দশম, শ্রেণি, ক্লাস, কোর্স',
                        'canonical_url' => null,
                    ],
                ],
            ],

            [
                'name' => 'HSC একাডেমিক',
                'slug' => 'hsc-academic',
                'overview' => 'এইচএসসি পর্যায়ের শিক্ষার্থীদের জন্য সায়েন্স, আর্টস, কমার্স ও আলিম শাখায় সম্পূর্ণ কোর্স, নোট, কুইজ ও প্রস্তুতির মডিউল।',
                'meta_title' => 'HSC একাডেমিক কোর্সসমূহ',
                'meta_description' => 'এইচএসসি পর্যায়ের শিক্ষার্থীদের জন্য সায়েন্স, আর্টস, কমার্স ও আলিম শাখার সম্পূর্ণ প্রস্তুতি কোর্স।',
                'meta_keywords' => 'HSC, সায়েন্স, আর্টস, কমার্স, আলিম, কোর্স',
                'canonical_url' => null,
                'children' => [
                    [
                        'name' => 'সায়েন্স',
                        'slug' => 'hsc-science',
                        'sort_order' => 1,
                        'overview' => 'এইচএসসি সায়েন্স শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স, নোট ও প্রস্তুতি।',
                        'meta_title' => 'HSC সায়েন্স কোর্সসমূহ',
                        'meta_description' => 'এইচএসসি সায়েন্স শিক্ষার্থীদের জন্য নোট, কুইজ ও প্রস্তুতির সম্পূর্ণ কোর্স।',
                        'meta_keywords' => 'HSC, সায়েন্স, কোর্স, নোট, কুইজ',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'আর্টস',
                        'slug' => 'hsc-arts',
                        'sort_order' => 2,
                        'overview' => 'এইচএসসি আর্টস শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স, নোট ও প্রস্তুতি।',
                        'meta_title' => 'HSC আর্টস কোর্সসমূহ',
                        'meta_description' => 'এইচএসসি আর্টস শিক্ষার্থীদের জন্য নোট, কুইজ ও প্রস্তুতির সম্পূর্ণ কোর্স।',
                        'meta_keywords' => 'HSC, আর্টস, কোর্স, নোট, কুইজ',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'কমার্স',
                        'slug' => 'hsc-commerce',
                        'sort_order' => 3,
                        'overview' => 'এইচএসসি কমার্স শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স, নোট ও প্রস্তুতি।',
                        'meta_title' => 'HSC কমার্স কোর্সসমূহ',
                        'meta_description' => 'এইচএসসি কমার্স শিক্ষার্থীদের জন্য নোট, কুইজ ও প্রস্তুতির সম্পূর্ণ কোর্স।',
                        'meta_keywords' => 'HSC, কমার্স, কোর্স, নোট, কুইজ',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'আলিম',
                        'slug' => 'hsc-alim',
                        'sort_order' => 4,
                        'overview' => 'এইচএসসি আলিম শিক্ষার্থীদের জন্য সম্পূর্ণ কোর্স, নোট ও প্রস্তুতি।',
                        'meta_title' => 'HSC আলিম কোর্সসমূহ',
                        'meta_description' => 'এইচএসসি আলিম শিক্ষার্থীদের জন্য নোট, কুইজ ও প্রস্তুতির সম্পূর্ণ কোর্স।',
                        'meta_keywords' => 'HSC, আলিম, কোর্স, নোট, কুইজ',
                        'canonical_url' => null,
                    ],
                ],
            ],

            [
                'name' => 'ভর্তি প্রস্তুতি',
                'slug' => 'admission-test',
                'overview' => 'ভর্তি পরীক্ষার প্রস্তুতির জন্য সম্পূর্ণ কোর্স। মেডিকেল, ইঞ্জিনিয়ারিং ও বিশ্ববিদ্যালয়ের ভর্তি পরীক্ষার জন্য সাজানো।',
                'meta_title' => 'ভর্তি প্রস্তুতি কোর্সসমূহ',
                'meta_description' => 'মেডিকেল, ইঞ্জিনিয়ারিং ও বিশ্ববিদ্যালয়ের ভর্তি পরীক্ষার জন্য সম্পূর্ণ প্রস্তুতি কোর্স।',
                'meta_keywords' => 'ভর্তি, মেডিকেল, ইঞ্জিনিয়ারিং, বিশ্ববিদ্যালয়, প্রস্তুতি, কোর্স',
                'canonical_url' => null,
                'children' => [
                    [
                        'name' => 'মেডিকেল',
                        'slug' => 'medical',
                        'sort_order' => 1,
                        'overview' => 'মেডিকেল ভর্তি পরীক্ষার জন্য সম্পূর্ণ প্রস্তুতি কোর্স।',
                        'meta_title' => 'মেডিকেল ভর্তি প্রস্তুতি কোর্স',
                        'meta_description' => 'মেডিকেল ভর্তি পরীক্ষার জন্য নোট, মক টেস্ট ও প্রস্তুতি কোর্স।',
                        'meta_keywords' => 'মেডিকেল, ভর্তি, কোর্স, প্রস্তুতি, নোট, মক টেস্ট',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'ইঞ্জিনিয়ারিং',
                        'slug' => 'engineering',
                        'sort_order' => 2,
                        'overview' => 'ইঞ্জিনিয়ারিং ভর্তি পরীক্ষার জন্য সম্পূর্ণ প্রস্তুতি কোর্স।',
                        'meta_title' => 'ইঞ্জিনিয়ারিং ভর্তি প্রস্তুতি কোর্স',
                        'meta_description' => 'ইঞ্জিনিয়ারিং ভর্তি পরীক্ষার জন্য নোট, মক টেস্ট ও প্রস্তুতি কোর্স।',
                        'meta_keywords' => 'ইঞ্জিনিয়ারিং, ভর্তি, কোর্স, প্রস্তুতি, নোট, মক টেস্ট',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'বিশ্ববিদ্যালয়',
                        'slug' => 'university',
                        'sort_order' => 3,
                        'overview' => 'বিশ্ববিদ্যালয় ভর্তি পরীক্ষার জন্য সম্পূর্ণ প্রস্তুতি কোর্স।',
                        'meta_title' => 'বিশ্ববিদ্যালয় ভর্তি প্রস্তুতি কোর্স',
                        'meta_description' => 'বিশ্ববিদ্যালয় ভর্তি পরীক্ষার জন্য নোট, মক টেস্ট ও প্রস্তুতি কোর্স।',
                        'meta_keywords' => 'বিশ্ববিদ্যালয়, ভর্তি, কোর্স, প্রস্তুতি, নোট, মক টেস্ট',
                        'canonical_url' => null,
                    ],
                ],
            ],

            [
                'name' => 'স্কিলস',
                'slug' => 'skills',
                'overview' => 'বিভিন্ন পেশাগত ও প্রযুক্তিগত দক্ষতা উন্নয়নের জন্য কোর্সসমূহ। গ্রাফিক্স ডিজাইন, ওয়েব ডেভেলপমেন্ট, ডিজিটাল মার্কেটিং সহ আধুনিক যুগের চাহিদা।',
                'meta_title' => 'স্কিলস কোর্সসমূহ',
                'meta_description' => 'গ্রাফিক্স ডিজাইন, ওয়েব ডেভেলপমেন্ট, ডিজিটাল মার্কেটিং সহ আধুনিক যুগের চাহিদা অনুযায়ী পেশাগত ও প্রযুক্তিগত দক্ষতা উন্নয়নের কোর্স।',
                'meta_keywords' => 'স্কিলস, গ্রাফিক্স ডিজাইন, ওয়েব ডেভেলপমেন্ট, ডিজিটাল মার্কেটিং, কোর্স',
                'canonical_url' => null,
                'children' => [
                    [
                        'name' => 'গ্রাফিক্স ডিজাইন',
                        'slug' => 'graphics-design',
                        'sort_order' => 1,
                        'overview' => 'গ্রাফিক্স ডিজাইনের জন্য সম্পূর্ণ কোর্স।',
                        'meta_title' => 'গ্রাফিক্স ডিজাইন কোর্স',
                        'meta_description' => 'গ্রাফিক্স ডিজাইন শিখুন, প্রফেশনাল প্রজেক্ট ও নোটসহ।',
                        'meta_keywords' => 'গ্রাফিক্স ডিজাইন, কোর্স, প্রজেক্ট, নোট',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'ওয়েব ডেভেলপমেন্ট',
                        'slug' => 'web-development',
                        'sort_order' => 2,
                        'overview' => 'ওয়েব ডেভেলপমেন্ট শিখতে সম্পূর্ণ কোর্স।',
                        'meta_title' => 'ওয়েব ডেভেলপমেন্ট কোর্স',
                        'meta_description' => 'ওয়েব ডেভেলপমেন্ট শিখুন, HTML, CSS, JavaScript ও প্রজেক্ট সহ।',
                        'meta_keywords' => 'ওয়েব ডেভেলপমেন্ট, কোর্স, HTML, CSS, JavaScript',
                        'canonical_url' => null,
                    ],
                    [
                        'name' => 'ডিজিটাল মার্কেটিং',
                        'slug' => 'digital-marketing',
                        'sort_order' => 3,
                        'overview' => 'ডিজিটাল মার্কেটিং শিখতে সম্পূর্ণ কোর্স।',
                        'meta_title' => 'ডিজিটাল মার্কেটিং কোর্স',
                        'meta_description' => 'ডিজিটাল মার্কেটিং শিখুন SEO, Social Media Marketing, Google Ads সহ।',
                        'meta_keywords' => 'ডিজিটাল মার্কেটিং, SEO, Social Media, Google Ads, কোর্স',
                        'canonical_url' => null,
                    ],
                ],
            ],
        ];

        foreach ($categories as $category) {
            // Create parent category
            $parent = Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'overview' => $category['overview'] ?? null,

                'meta_title' => $category['meta_title'] ?? null,
                'meta_description' => $category['meta_description'] ?? null,
                'meta_keywords' => $category['meta_keywords'] ?? null,
                'canonical_url' => $category['canonical_url'] ?? null,
                'parent_id' => null,
            ]);

            // Create children categories
            if (!empty($category['children'])) {
                foreach ($category['children'] as $child) {
                    Category::create([
                        'name' => $child['name'],
                        'slug' => $child['slug'],
                        'sort_order' => $child['sort_order'] ?? 0,
                        'overview' => $child['overview'] ?? null,

                        'meta_title' => $child['meta_title'] ?? null,
                        'meta_description' => $child['meta_description'] ?? null,
                        'meta_keywords' => $child['meta_keywords'] ?? null,
                        'canonical_url' => $child['canonical_url'] ?? null,
                        'parent_id' => $parent->id,
                    ]);
                }
            }
        }
    }
}
