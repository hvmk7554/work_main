<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Program;
use App\Observers\CourseObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot()
    {
        $this->registerObservers();
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }

    private function registerObservers()
    {
        Course::observe(CourseObserver::class);
    }
}
