<?php

namespace Tests\Feature\Commands;

use App\Jobs\QueryStatusPayment;
use App\Models\Order;
use App\Models\OrderDetail;
use Database\Seeders\StockSeeder;
use Database\Seeders\TestDatabaseSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CommandQueryPaymentsTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testQueryPaymentCommand()
    {
        Queue::fake();
        $this->seed([
            TestDatabaseSeeder::class,
            UserSeeder::class,
            StockSeeder::class,
        ]);
        factory(Order::class, 2)->create();
        factory(OrderDetail::class, 5)->create();
        $this->artisan('payments:query')
            ->assertExitCode(0);

        Queue::assertPushed(QueryStatusPayment::class);
    }

    /**
     *
     * @return void
     */
    public function testJobNotPushedWhenNotOrders()
    {
        Queue::fake();
        $this->seed([
            TestDatabaseSeeder::class,
            UserSeeder::class,
            StockSeeder::class,
        ]);
        $this->artisan('payments:query')
            ->assertExitCode(0);

        Queue::assertNotPushed(QueryStatusPayment::class);
    }
}
