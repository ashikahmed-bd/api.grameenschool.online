<?php

namespace App\Http\Controllers;

use App\Enums\EnrollmentStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Events\OrderPaidEvent;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentMethodResource;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Services\BkashService;
use App\Services\EnvService;
use App\Services\SslCommerzService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{

    public function index()
    {
        $gateways = PaymentGateway::query()->orderBy('created_at', 'desc')->get();
        return  PaymentMethodResource::collection($gateways);
    }

    public function update(Request $request, PaymentGateway $gateway, EnvService $env)
    {
        $request->validate([
            'enabled' => 'required|boolean',
            'sandbox' => 'required|boolean',
            'credentials' => 'required|array',
        ]);

        if (! $request->user()->tokenCan((UserRole::ADMIN)->value)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update payment gateway settings.',
            ], Response::HTTP_FORBIDDEN);
        }

        $gateway->update([
            'enabled' => $request->enabled,
            'sandbox' => $request->sandbox,
            'credentials' => $request->credentials,
        ]);

        if ($gateway->key === 'sslcommerz') {
            $env->set([
                'SSLCOMMERZ_STORE_ID' => $request->credentials['store_id'] ?? '',
                'SSLCOMMERZ_STORE_PASSWORD' => $request->credentials['store_password'] ?? '',
                'SSLCOMMERZ_SANDBOX' => $request->sandbox ? 'true' : 'false',
            ]);
        } elseif ($gateway->key === 'bkash') {
            $env->set([
                'BKASH_APP_KEY' => $request->credentials['app_key'] ?? '',
                'BKASH_APP_SECRET' => $request->credentials['app_secret'] ?? '',
                'BKASH_USERNAME' => $request->credentials['username'] ?? '',
                'BKASH_PASSWORD' => $request->credentials['password'] ?? '',
                'BKASH_SANDBOX' => $request->sandbox ? 'true' : 'false',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Gateway updated successfully',
        ], Response::HTTP_OK);
    }


    public function getInvoice(Request $request)
    {
        $invoiceId = $request->query('invoice_id');

        $order = Order::query()->where('invoice_id', $invoiceId)->firstOrFail();

        return OrderResource::make($order);
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'string'],
            'invoice_id' => ['required', 'string', Rule::exists('orders', 'invoice_id')],
        ]);

        $order = Order::where('invoice_id', $request->invoice_id)->firstOrFail();

        if ($order->paid_at) {
            return response()->json([
                'success' => false,
                'message' => 'Order already paid',
            ], 409);
        }

        Payment::firstOrCreate(
            ['invoice_id' => $order->invoice_id],
            [
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'amount' => $order->subtotal,
                'status' => PaymentStatus::CREATED,
            ]
        );

        $method = strtolower($request->payment_method);

        return match ($method) {
            'sslcommerz' => response()->json(
                app(SslCommerzService::class)->initiate($order)
            ),

            'bkash' => response()->json(
                app(BkashService::class)->initiate($order)
            ),

            default => response()->json(['message' => 'Unsupported payment gateway'], 422),
        };
    }

    public function success(Request $request)
    {
        $invoiceId = $request->get('tran_id');

        $order = Order::query()->where('invoice_id', $invoiceId)->firstOrFail();

        if ($order->status === OrderStatus::PAID) {
            return response()->json(['message' => 'Order already completed']);
        }

        if ($order) {
            event(new OrderPaidEvent($order));
        }

        return redirect()->away(config('app.client_url') . '/payment/success?' . http_build_query([
            'tran_id' => $request->get('tran_id'),
        ]));
    }

    public function failed(Request $request)
    {
        $invoiceId = $request->get('tran_id');
        $order = Order::query()->where('invoice_id', $invoiceId)->first();

        if ($order) {
            $order->update([
                'status' => OrderStatus::FAILED,
            ]);
            $order->payment?->update([
                'status' => PaymentStatus::FAILED,
            ]);
        }

        return redirect()->to(config('app.client_url') . '/payment/failed?' . http_build_query([
            'tran_id' => $request->get('tran_id'),
        ]));
    }


    public function cancel(Request $request)
    {
        $invoiceId = $request->get('tran_id');
        $order = Order::query()->where('invoice_id', $invoiceId)->first();

        if ($order->status !== OrderStatus::PAID) {
            $order->update([
                'status' => OrderStatus::FAILED,
            ]);
            $order->payment?->update([
                'status' => PaymentStatus::CANCELLED,
            ]);
        }

        return redirect()->to(config('app.client_url') . '/payment/cancel?' . http_build_query([
            'tran_id' => $request->get('tran_id'),
        ]));
    }


    public function approved(Request $request)
    {
        $invoiceId = $request->get('invoice_id');

        $order = Order::query()->where('invoice_id', $invoiceId)->first();

        if ($order->status === OrderStatus::PAID) {
            return response()->json(['message' => 'Order already completed']);
        }

        if ($order) {
            event(new OrderPaidEvent($order));
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment Approved successfully',
        ], Response::HTTP_OK);
    }

    public function verify(Request $request, Order $order)
    {
        $request->validate([
            'amount'   => 'required|numeric|min:1',
            'method'   => ['required', new Enum(PaymentMethod::class)],
        ]);

        if ($request->amount > $order->due) {
            return response()->json([
                'message' => 'Over payment not allowed'
            ], 422);
        }

        Payment::create([
            'order_id' => $order->id,
            'user_id'  => $order->user_id,
            'invoice_id' => $order->invoice_id,
            'transaction_id' => uniqid('trx_'),
            'amount' => $request->amount,
            'method' => $request->method,
            'status' => PaymentStatus::SUCCESS,
            'paid_at' => now(),
        ]);

        $order->paid += $request->amount;
        $order->due = $order->total - $order->paid;

        if ($order->paid >= $order->total) {
            $order->status = OrderStatus::PAID;
            $order->paid_at = now();

            // unlock enrollment
            Enrollment::where('order_id', $order->id)
                ->update([
                    'status' => EnrollmentStatus::ONGOING,
                    'enrolled_at' => now(),
                ]);
        } else {
            Enrollment::query()
                ->where('order_id', $order->id)
                ->update(['status' => EnrollmentStatus::ONGOING]);

            $order->status = OrderStatus::PARTIAL;
        }

        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment successful',
        ]);
    }
}
