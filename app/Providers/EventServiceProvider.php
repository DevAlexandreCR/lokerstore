<?php

namespace App\Providers;

use App\Events\OnProductUpdateEvent;
use App\Events\OnStockCreatedOrUpdatedEvent;
use App\Listeners\DisableProductIfStockIsEmpty;
use App\Listeners\SetStockProduct;
use App\Models\Admin\Admin;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Observers\AdminObserver;
use App\Observers\OrderDetailObserver;
use App\Observers\OrderObserver;
use App\Observers\PaymentObserver;
use App\Observers\ProductObserver;
use App\Observers\StockObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        OnStockCreatedOrUpdatedEvent::class => [
            SetStockProduct::class,
        ],
        OnProductUpdateEvent::class => [
            DisableProductIfStockIsEmpty::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        Product::observe(ProductObserver::class);
        Stock::observe(StockObserver::class);
        User::observe(UserObserver::class);
        Payment::observe(PaymentObserver::class);
        Order::observe(OrderObserver::class);
        OrderDetail::observe(OrderDetailObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
