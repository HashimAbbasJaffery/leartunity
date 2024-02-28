<?php

namespace App\Providers;

use App\Interfaces\Certificate;
use App\Interfaces\TrackingService;
use App\Services\CourseCertificate;
use App\Services\VideoTrackingService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(Certificate::class, CourseCertificate::class);
    }
}
