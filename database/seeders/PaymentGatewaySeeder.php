<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $gateways = [
            [
                'key' => 'sslcommerz',
                'name' => 'SSLCommerz',
                'enabled' => true,
                'logo' => 'logo/sslcommerz.png',
                'sandbox' => true,
                'credentials' => json_encode([
                    'store_id' => 'tohat687b2a1f38252',
                    'store_password' => 'tohat687b2a1f38252@ssl',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'bkash',
                'name' => 'bKash',
                'enabled' => true,
                'logo' => 'logo/bkash.png',
                'sandbox' => false,
                'credentials' => json_encode([
                    'app_key' => 'YZvDD1QzdUtEDYIJzCSqPxfgtc',
                    'app_secret' => '5TnFQGN2fcqU8XyHexbEZJMQMC1R2tSJTEIe0AbcXt839lnqA0tG',
                    'username' => '01516598533',
                    'password' => '#N$Om5FRCpJ',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::create($gateway);
        }
    }
}
