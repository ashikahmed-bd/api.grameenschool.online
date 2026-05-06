<?php

namespace App\Providers;

use App\Models\User;
use App\Channels\SmsChannel;
use App\Policies\RolePolicy;
use App\Services\BkashService;
use App\Services\SslCommerzService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SslCommerzService::class, function ($app) {
            return new SslCommerzService(
                config('services.sslcommerz.store_id'),
                config('services.sslcommerz.store_password'),
                config('services.sslcommerz.sandbox'),
            );
        });

        $this->app->bind(BkashService::class, function ($app) {
            return new BkashService(
                config('services.bkash.app_key'),
                config('services.bkash.app_secret'),
                config('services.bkash.username'),
                config('services.bkash.password'),
                config('services.bkash.sandbox'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $this->app->make(ChannelManager::class)->extend('sms', function ($app) {
            return new SmsChannel();
        });

        Gate::policy(User::class, RolePolicy::class);
    }
}
