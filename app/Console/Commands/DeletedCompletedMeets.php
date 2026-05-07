<?php

namespace App\Console\Commands;

use App\Enums\MeetStatus;
use App\Models\Meet;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeletedCompletedMeets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meets:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete completed meets older than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Meet::query()->where('status', MeetStatus::ENDED->value)
            ->where('end_time', '<', Carbon::now()->subDays(7))
            ->delete();

        $this->info("Deleted {$count} old completed meets.");
    }
}
