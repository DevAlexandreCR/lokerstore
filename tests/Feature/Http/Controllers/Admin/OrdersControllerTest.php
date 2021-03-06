<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Payer;
use App\Constants\Admins;
use App\Constants\Orders;
use App\Constants\Roles;
use App\Models\Admin\Admin;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Stock;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\StockSeeder;
use Tests\TestCase;
use Database\Seeders\UserSeeder;

class OrdersControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->seed([
            TestDatabaseSeeder::class,
            UserSeeder::class,
            StockSeeder::class,
        ]);
        factory(Order::class, 2)->create();
        factory(OrderDetail::class, 5)->create();
        $this->admin = factory(Admin::class)->create();
        $this->admin->assignRole(Roles::ADMIN);
        $this->withoutExceptionHandling();
    }

    public function testAnAdminCanViewOrdersIndex(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('orders.index'));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders');
    }

    public function testAnAdminCanViewAnOrder(): void
    {
        $id = Order::all()->random()->id;

        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('orders.show', $id));

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('order');
    }

    public function testAnAdminCanSeeTheViewToCreateOrders(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(
            route('orders.create')
        );

        $response
            ->assertStatus(200)
            ->assertViewIs('admin.orders.create')
            ->assertViewHas('products');
    }

    public function testAnAdminCanCreateAnOrder(): void
    {
        $stock = Stock::all()->random();
        $stock1 = Stock::all()->random();
        $response = $this->actingAs($this->admin, Admins::GUARDED)->post(
            route('orders.store', [
                'amount'        => 50000,
                'details'       => [
                    [
                        'stock_id' => $stock->id,
                        'quantity' => 1,
                    ],
                    [
                        'stock_id' => $stock1->id,
                        'quantity' => 1,
                    ],
                ]
            ])
        );

        $response
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'admin_id' => $this->admin->id,
        ]);
        $this->assertDatabaseHas('order_details', [
            'stock_id' => $stock->id,
            'quantity' => 1,
        ]);
        $this->assertDatabaseHas('order_details', [
            'stock_id' => $stock1->id,
            'quantity' => 1,
        ]);
    }

    public function testAnAdminCanUpdateAnOrder(): void
    {
        $id = Order::all()->random()->id;

        $response = $this->actingAs($this->admin, Admins::GUARDED)->patch(
            route('orders.update', $id),
            [
                'status' => Orders::STATUS_CANCELED,
            ]
        );

        $response
            ->assertStatus(302)
            ->assertRedirect(route('orders.show', $id));

        $this->assertDatabaseHas('orders', [
            'id' => $id,
            'status' => Orders::STATUS_CANCELED,
        ]);
    }

    public function testAnAdminCanDeleteAnOrder(): void
    {
        $id = Order::all()->random()->id;

        $response = $this->actingAs($this->admin, Admins::GUARDED)->delete(route('orders.destroy', $id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('orders.index'));

        $this->assertDatabaseMissing('orders', [
            'id' => $id,
        ]);
    }

    public function testAnAdminCanQueryAnOrderToP2P(): void
    {
        $order = Order::all()->random();
        factory(Payer::class)->create();
        factory(Payment::class)->create([
            'order_id' => $order->id,
        ]);

        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('orders.verify', $order->id));

        $response
            ->assertStatus(302);
    }

    public function testAnAdminCanReverseAPurchase(): void
    {
        $order = Order::all()->random();
        factory(Payer::class)->create();
        factory(Payment::class)->create([
            'order_id' => $order->id,
        ]);
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('orders.reverse', $order->id));

        $response
            ->assertStatus(302);
    }
}
