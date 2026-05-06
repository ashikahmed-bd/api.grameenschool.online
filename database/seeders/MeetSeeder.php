<?php

namespace Database\Seeders;

use App\Enums\MeetProvider;
use App\Enums\MeetStatus;
use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Meet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MeetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('role', (UserRole::INSTRUCTOR)->value)->first();

        $meets = [
            [
                'topic'      => 'বিজ্ঞান ক্লাস: মৌলিক ধারণা',
                'provider'   => 'google_meet',
                'meeting_id' => '1234567890',
                'join_url'   => 'https://meet.google.com/abc-defg-hij',
                'host_url'   => 'https://meet.google.com/hostlink1',
            ],
            [
                'topic'      => 'গণিত সমস্যা সমাধান ও টিপস',
                'meeting_id' => '0987654321',
                'join_url'   => 'https://zoom.us/j/1234567890',
                'host_url'   => 'https://zoom.us/hostlink2',
            ],
        ];

        foreach ($meets as $meet) {
            Meet::query()->create(array_merge($meet, [
                'course_id' => null,
                'host_id' => $user->id,
                'provider' => MeetProvider::ZOOM,
                'topic'     => $meet['topic'],
                'meeting_id' => $meet['meeting_id'],
                'join_url'   => $meet['join_url'],
                'host_url'   => $meet['host_url'],
                'date'       => Carbon::today(),
                'time'       => Carbon::today()->setTime(20, 0, 0)->format('H:i:s'),
                'status'     => MeetStatus::SCHEDULED,
            ]));
        }
    }
}
