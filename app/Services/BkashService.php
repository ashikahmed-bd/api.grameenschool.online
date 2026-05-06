<?php

namespace App\Services;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Events\OrderPaidEvent;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class BkashService
{
    protected string $appKey;
    protected string $appSecret;
    protected string $username;
    protected string $password;
    protected bool $sandbox;
    protected ?string $token = null;

    public function __construct(string $appKey, string $appSecret, string $username, string $password, bool $sandbox = true)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->username = $username;
        $this->password = $password;
        $this->sandbox = $sandbox;
    }

    protected function getBaseUrl(): string
    {
        return $this->sandbox ? 'https://tokenized.sandbox.bka.sh' : 'https://tokenized.pay.bka.sh';
    }


    /**
     * @throws ConnectionException
     */
    public function getAccessToken()
    {
        $response = Http::acceptJson()->withHeaders([
            'username' => $this->username,
            'password' => $this->password,
        ])->post($this->getBaseUrl() . "/v1.2.0-beta/tokenized/checkout/token/grant", [
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ]);

        if ($response->successful()) {
            $this->token = $response->json('id_token');
            return $this->token;
        }

        return null;
    }


    /**
     * @throws ConnectionException
     */
    public function initiate(Order $order)
    {

        if (!$this->token) {
            $this->getAccessToken();
        }

        $response = Http::acceptJson()->withHeaders([
            'Authorization' => $this->token,
            'X-APP-Key' =>  $this->appKey,
        ])->post($this->getBaseUrl() . "/v1.2.0-beta/tokenized/checkout/create", [
            'amount' => $order->due_amount,
            'currency' => 'BDT',
            'payerReference' => $order->user->phone,
            'mode' => '0011',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order->invoice_id,
            'callbackURL' => config('app.url') . '/api/payment/bkash/callback',
        ]);

        $data = $response->json();

        if ($response->ok() && ($data['statusCode'] ?? null) === '0000') {
            return [
                'success' => true,
                'redirect_url' => $data['bkashURL'] ?? null,
            ];
        }
    }


    public function callback(Request $request)
    {
        $paymentID = $request->query('paymentID');

        if (!$paymentID) {
            return response()->json(['message' => 'paymentID missing'], 400);
        }

        if (!$this->token) {
            $this->getAccessToken();
        }

        $response = Http::acceptJson()->withHeaders([
            'Authorization' => $this->token,
            'X-APP-Key' => $this->appKey,
        ])->post($this->getBaseUrl() . "/v1.2.0-beta/tokenized/checkout/execute", [
            'paymentID' => $paymentID,
        ]);

        $data = $response->json();

        $invoiceId = $data['merchantInvoiceNumber'] ?? null;

        if (($data['transactionStatus'] ?? null) === 'Completed' && $invoiceId) {
            $order = Order::query()->where('invoice_id', $invoiceId)->first();

            if ($order && $order->status !== OrderStatus::PAID) {
                event(new OrderPaidEvent($order));
            }

            return redirect()->to(config('app.client_url') . '/payment/success?' . http_build_query([
                'tran_id' => $invoiceId,
            ]));
        }

        return redirect()->to(config('app.client_url') . '/payment/cancel?' . http_build_query([
            'tran_id' => $invoiceId ?? 'unknown',
        ]));
    }
}
