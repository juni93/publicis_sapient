<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observersPath = 'App\Observers';
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        /* Registered::class => [
            SendEmailVerificationNotification::class,
        ], */];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /* Associa un observer a tutti i modelli che definiscono una classe Observer */
        foreach ($this->app["loadModels"] as $relation => $class) {
            if (class_exists($observer = sprintf('%s\%sObserver', $this->observersPath, $relation))) {
                $class::observe($observer);
            }
        }
    }
}
