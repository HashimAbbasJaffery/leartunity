<?php

namespace App\Providers;

use App\Events\FollowerCounter;
use App\Listeners\FollowerListener;
use App\Listeners\StripeEventListener;
use App\Models\Certificate;
use App\Observers\CertificateObserver;
use App\Observers\CommentObserver;
use App\Observers\ContentObserver;
use App\Observers\TrackingObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\Comment;
use App\Models\Tracker;
use App\Models\Content;
use App\Models\User;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        WebhookReceived::class => [
            StripeEventListener::class
        ],
        FollowerCounter::class => [
            FollowerListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Comment::observe(CommentObserver::class);
        // Tracker::observe(TrackingObserver::class);
        Certificate::observe(CertificateObserver::class);
        Content::observe(ContentObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
