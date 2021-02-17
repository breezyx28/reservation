<?php

namespace App\Providers;

use App\Events\InvoicesEvent;
use App\Events\LabInvoiceEvent;
use App\Events\RegisterUsersHolderEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RegisterUsersHolderEvent::class => [
            \App\Listeners\SaveUsersHolderDataListener::class,
        ],
        LabInvoiceEvent::class => [
            \App\Listeners\LabInvoiceListener::class
        ],
        InvoicesEvent::class => [
            \App\Listeners\InvoicesListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
