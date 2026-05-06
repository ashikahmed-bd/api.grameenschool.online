<?php

namespace App\Listeners;

use App\Enums\OrderStatus;
use App\Models\Enrollment;
use App\Enums\PaymentStatus;
use App\Events\OrderPaidEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessOrderPayment
{

    /**
     * Handle the event.
     */
    public function __invoke(OrderPaidEvent $event): void
    {
        $order = $event->order;

        DB::transaction(function () use ($order) {

            $order->update([
                'status' => OrderStatus::PAID,
                'paid_at' => now(),
            ]);

            $order->payment?->update([
                'status' => PaymentStatus::SUCCESS,
                'paid_at' => now(),
            ]);

            foreach ($order->items as $item) {
                // course enrollment
                $course = $item->course;

                if ($item->course_id) {
                    Enrollment::updateOrCreate(
                        ['course_id' => $item->course_id, 'user_id' => $order->user_id],
                        [
                            'order_id' => $order->id,
                            'expires_at' => $course->access_days ? now()->addDays($course->access_days) : null,
                            'updated_at' => now()
                        ]
                    );
                }
            }
        });
    }
}
