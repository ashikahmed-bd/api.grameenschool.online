<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class SslCommerzService
{

    protected string $storeId;
    protected string $storePassword;
    protected bool $sandbox;

    public function __construct(string $storeId, string $storePassword, bool $sandbox = true)
    {
        $this->storeId = $storeId;
        $this->storePassword = $storePassword;
        $this->sandbox = $sandbox;
    }

    public function initiate(Order $order): array
    {
        $baseUrl = $this->sandbox
            ? 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://securepay.sslcommerz.com/gwprocess/v4/api.php';

        $payload = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $order->due,
            'currency' => 'BDT',
            'tran_id' => $order->invoice_id,
            'success_url' => env('APP_URL') . '/api/payment/success',
            'fail_url' => env('APP_URL') . '/api/payment/failed',
            'cancel_url' => env('APP_URL') . '/api/payment/cancel',

            'cus_name' => $order->user->name,
            'cus_email' => $order->user->email ?? 'demo@example.com',
            'cus_add1' => 'Address',
            'cus_city' => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $order->user->phone,

            'shipping_method' => 'NO',
            'product_name' => 'LMS Courses',
            'product_category' => 'Education',
            'product_profile' => 'general',
        ];

        $response = Http::asForm()->post($baseUrl, $payload);

        if ($response->ok() && $response['status'] === 'SUCCESS') {
            return [
                'success' => true,
                'redirect_url' => $response['GatewayPageURL'],
            ];
        }

        return [
            'success' => false,
            'message' => 'SSLCommerz connection failed',
            'response' => $response->json(),
        ];
    }
}
