<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Payer;
use App\Constants\Orders;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TestDatabaseSeeder;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $stock;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withoutExceptionHandling();
        $this->seed([
            TestDatabaseSeeder::class,
        ]);

        $this->user = factory(User::class)->create([
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $this->user->cart = factory(Cart::class)->create([
            'user_id' => $this->user->id,
        ]);
        $this->stock = factory(Stock::class)->create([
            'quantity' => 5,
        ]);
        factory(Payer::class)->create();

        $this->user->cart->stocks()->attach($this->stock->id, ['quantity' => 2]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore(): void
    {
        $response = $this->actingAs($this->user)
            ->post(
                route('user.order.store', $this->user),
                [
                'user_id' => $this->user->id,
                ]
            );

        $redirectUrl = $response->headers->get('Location');
        $response
            ->assertStatus(302)
            ->assertRedirect($redirectUrl);

        $this->assertDatabaseHas(
            'orders',
            [
                'user_id' => $this->user->id,
            ]
        );

        $this->assertDatabaseHas(
            'stocks',
            [
                'quantity' => 3,
            ]
        );
    }

    public function testGetStatusPaymentApproved(): void
    {
        $order = factory(Order::class)->create([
            'user_id' => $this->user->id,
        ]);
        factory(OrderDetail::class)->create([
            'order_id' => $order->id,
        ]);
        factory(Payment::class)->create([
            'order_id' => $order->id,
            'request_id' => 367394,
        ]);
        $response = $this->actingAs($this->user)
            ->post(
                route('user.order.status', [$this->user->id]),
                [
                'order_id' => $order->id,
                ]
            );

        $response
            ->assertStatus(302)
            ->assertRedirect(route('user.order.show', [$this->user->id, $order->id]))
            ->assertSessionHas('message');

        $this->assertDatabaseHas(
            'orders',
            [
                'id' => $order->id,
                'status' => Orders::STATUS_PENDING_SHIPMENT,
            ]
        );
    }

    public function testGetStatusPaymentPending(): void
    {
        $order = factory(Order::class)->create([
            'user_id' => $this->user->id,
        ]);
        factory(OrderDetail::class)->create([
            'order_id' => $order->id,
        ]);
        factory(Payment::class)->create([
            'order_id' => $order->id,
            'request_id' => 367478,
        ]);
        $response = $this->actingAs($this->user)
            ->post(
                route('user.order.status', [$this->user->id]),
                [
                    'order_id' => $order->id,
                ]
            );

        $response
            ->assertStatus(302)
            ->assertRedirect(route('user.order.show', [$this->user->id, $order->id]))
            ->assertSessionHas('message');

        $this->assertDatabaseHas(
            'orders',
            [
                'id' => $order->id,
            //                'status' => Orders::STATUS_PENDING_PAY
            ]
        );
    }

    public function testAllStocksHasRestoredWhenOrderCanceled(): void
    {
        $order = factory(Order::class)->create([
            'user_id' => $this->user->id,
        ]);
        factory(OrderDetail::class)->create([
            'stock_id' => $this->stock->id,
            'order_id' => $order->id,
        ]);
        factory(Payment::class)->create([
            'order_id' => $order->id,
            'request_id' => 367478,
        ]);

        $order->status = Orders::STATUS_CANCELED;
        $order->save();

        $this->assertDatabaseHas(
            'stocks',
            [
                'id'       => $this->stock->id,
                'quantity' => 5,
            ]
        );
    }
}
