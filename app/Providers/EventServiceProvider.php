<?php

namespace App\Providers;

use App\Events\ActualiterCreationEvent;
use App\Events\BlogCreationEvent;
use App\Events\ContacteEvent;
use App\Events\InscriptionEvent;
use App\Events\PortfolioCreateEvent;
use App\Listeners\ActualiterCreationListener;
use App\Listeners\BlogCreationListener;
use App\Listeners\ContacteListener;
use App\Listeners\InscriptionListener;
use App\Listeners\PortfolioCreateListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        InscriptionEvent::class => [
            InscriptionListener::class
        ],
        ContacteEvent::class => [
            ContacteListener::class
        ],
        BlogCreationEvent::class => [
            BlogCreationListener::class
        ],
        ActualiterCreationEvent::class => [
            ActualiterCreationListener::class
        ],
        PortfolioCreateEvent::class => [
            PortfolioCreateListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
