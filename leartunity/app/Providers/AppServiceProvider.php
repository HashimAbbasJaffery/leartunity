<?php

namespace App\Providers;

use App\Classes\Points;
use App\Interfaces\Certificate;
use App\Interfaces\LinkedList;
use App\Interfaces\TrackingService;
use App\Services\ContentService;
use App\Services\CourseCertificate;
use App\Services\VideoTrackingService;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\CashierServiceProvider;
use Stripe\StripeClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(TrackingService::class, VideoTrackingService::class);
        $this->app->bind(LinkedList::class, ContentService::class);
        $this->app->bind(Certificate::class, CourseCertificate::class);
        $this->app->when(StripeClient::class)
                    ->needs('$config')
                    ->give(env("STRIPE_SECRET"));
    }
}
