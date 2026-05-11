<?php

namespace App\Listeners;

use App\Enums\EnrollmentStatus;
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

                $course = $item->course;

                if ($item->course_id && $course) {

                    $accessDays = (int) $course->access_days;
                    Enrollment::updateOrCreate(
                        [
                            'course_id' => $item->course_id,
                            'user_id'   => $order->user_id,
                        ],
                        [
                            'order_id'    => $order->id,
                            'progress'    => 0,
                            'status'    => EnrollmentStatus::ONGOING,
                            'certificate'  => false,
                            'enrolled_at'  => now(),
                            'expires_at'   => $accessDays > 0
                                ? now()->addDays($accessDays)
                                : null,
                            'updated_at'   => now(),
                        ]
                    );
                }
            }
        });
    }
}
