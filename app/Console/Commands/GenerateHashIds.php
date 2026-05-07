<?php

namespace App\Console\Commands;

use App\Models\User;
use Hashids\Hashids;
use Illuminate\Console\Command;

class GenerateHashIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hashids:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hashids = new Hashids(config('app.key'), 10);

        User::query()
            ->whereNull('hashid')
            ->chunkById(100, function ($users) use ($hashids) {
                foreach ($users as $user) {
                    $user->updateQuietly([
                        'hashid' => $hashids->encode($user->id),
                    ]);
                    $this->info("Generated hashid for User ID: {$user->id}");
                }
            });

        $this->info('Done.');
    }
}
