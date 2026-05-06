<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(BatchSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PageSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(PaymentGatewaySeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(BenefitSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseContentSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(MeetSeeder::class);
        $this->call(CouponSeeder::class);
    }
}
