<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Database\Seeders\AdminSeeder;
use App\Constants\Admins;
use App\Constants\Roles;
use App\Models\Admin\Admin;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\StockSeeder;
use Tests\TestCase;
use Database\Seeders\UserSeeder;

class OrderDetailsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            TestDatabaseSeeder::class,
            UserSeeder::class,
            StockSeeder::class,
            AdminSeeder::class,
        ]);
        factory(Order::class, 2)->create();
        factory(OrderDetail::class, 5)->create();
        $this->admin = factory(Admin::class)->create();
        $this->admin->assignRole(Roles::ADMIN);
    }

    public function testAnAdminCanUpdateAnOrderDetail(): void
    {
        $stock = factory(Stock::class)->create([
            'quantity' => 20,
        ]);

        $detail = factory(OrderDetail::class)->create([
            'stock_id' => $stock->id,
            'quantity' => 5,
        ]);

        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->patch(
                route('order_details.update', $detail->id),
                [
                'stock_id' => $detail->stock_id,
                'quantity' => 3,
                ]
            );

        $response
            ->assertStatus(302)
            ->assertRedirect(route('orders.show', $detail->order_id))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('order_details', [
            'id' => $detail->id,
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('stocks', [
            'id' => $detail->stock_id,
            'quantity' => 17,
        ]);
    }

    public function testAnAdminCanDeleteAnOrderDetail(): void
    {
        $detail = OrderDetail::all()->random();
        $id = $detail->id;
        $order = $detail->order;
        $order->orderDetails->each(function ($detail) use ($order) {
            $order->amount += $detail->total_price;
        });
        $order->save();
        $amount = $detail->total_price;
        $amountOrder = $order->amount;

        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('order_details.destroy', $detail->id));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('orders.show', $detail->order_id))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('order_details', [
            'id' => $id,
        ]);
        $this->assertDatabaseHas('orders', [
            'id' => $detail->order_id,
            'amount' => $amountOrder - $amount,
        ]);
    }
}
