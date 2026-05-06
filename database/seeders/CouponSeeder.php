<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'course_id' => null,
                'owner_id' => 1,
                'code' => 'WELCOME10',
                'discount' => 10,
                'commission' => 20,
                'type' => 'percent',
                'usage_limit' => 100,
                'used_count' => 0,
                'active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addDays(30),
            ],
            [
                'course_id' => 1,
                'owner_id' => null,
                'code' => 'FLAT50',
                'discount' => 50,
                'commission' => null,
                'type' => 'fixed',
                'usage_limit' => null,
                'used_count' => 0,
                'active' => true,
                'starts_at' => now(),
                'expires_at' => now()->addDays(15),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
