<?php

namespace App\Providers;

use App\Events\Orders\OrderCompleted;
use App\Events\Orders\OrderMerged;
use App\Events\Orders\OrderPaid;
use App\Events\Orders\OrderSubmitted;
use App\Events\Product\ProductCreated;
use App\Events\Product\ProductDeleted;
use App\Events\Product\ProductUpdated;
use App\Events\Variation\VariationCreated;
use App\Events\Variation\VariationDeleted;
use App\Events\Variation\VariationUpdated;
use App\Listeners\Orders\OrderMergeListener;
use App\Listeners\Orders\OrderSubmittedListener;
use App\Listeners\Orders\SendOrderCompletedNotification;
use App\Listeners\Orders\SendOrderMergedNotification;
use App\Listeners\Orders\SendOrderPaidNotification;
use App\Listeners\Orders\OrderPaidListener;
use App\Listeners\Orders\SendOrderSubmittedNotification;
use App\Listeners\Product\ProductCreatedListener;
use App\Listeners\Product\ProductDeletedListener;
use App\Listeners\Product\ProductUpdatedListener;
use App\Listeners\Variation\VariationCreatedListener;
use App\Listeners\Variation\VariationDeletedListener;
use App\Listeners\Variation\VariationUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderPaid::class => [
            SendOrderPaidNotification::class,
            OrderPaidListener::class,
        ],
        OrderSubmitted::class => [
            OrderSubmittedListener::class,
            SendOrderSubmittedNotification::class,
        ],
        OrderMerged::class => [
            SendOrderMergedNotification::class,
            OrderMergeListener::class,
        ],
        OrderCompleted::class => [
            SendOrderCompletedNotification::class,
        ],
        ProductCreated::class => [
            ProductCreatedListener::class,
        ],
        ProductUpdated::class => [
            ProductUpdatedListener::class,
        ],
        ProductDeleted::class => [
            ProductDeletedListener::class,
        ],
        VariationCreated::class => [
            VariationCreatedListener::class,
        ],
        VariationUpdated::class => [
            VariationUpdatedListener::class,
        ],
        VariationDeleted::class => [
            VariationDeletedListener::class,
        ],
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
