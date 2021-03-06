<?php

namespace Tests\Feature\Policies;

use App\Models\Payer;
use App\Constants\Admins;
use App\Constants\Orders;
use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Database\Seeders\StockSeeder;
use Database\Seeders\TestDatabaseSeeder;
use Tests\TestCase;
use Database\Seeders\UserSeeder;

class OrdersPolicyTest extends TestCase
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
        factory(Payer::class)->create();
        factory(Order::class, 2)->create();
        factory(OrderDetail::class, 5)->create();
        $this->admin = factory(Admin::class)->create();
    }

    public function testIndexNotAuthorized(): void
    {
        $response = $this->actingAs($this->admin, Admins::GUARDED)->get(route('orders.index'));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotViewAOrder(): void
    {
        $id = Order::all()->random()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('orders.show', $id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotUpdateOrders(): void
    {
        $id = Order::all()->random()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->put(route('orders.update', $id));

        $response->assertStatus(403);
    }

    public function testAdminWithoutPermissionCannotDeleteAOrder(): void
    {
        $id = factory(Order::class)->create()->id;
        $response = $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('orders.destroy', $id));

        $response->assertStatus(403);
    }

    public function testAllOrdersRoutesWithPermissions(): void
    {
        $this->withoutExceptionHandling();
        $id = Order::all()->random()->id;
        factory(Payment::class)->create([
            'order_id' => $id,
        ]);
        $role = factory(Role::class)->create();

        $role->syncPermissions([
            Permissions::VIEW_ORDERS,
            Permissions::EDIT_ORDERS,
            Permissions::DELETE_ORDERS,
        ]);

        $this->admin->assignRole($role->name);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->get(route('orders.index'))->assertStatus(200);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->put(
                route('orders.update', $id),
                [
                    'status'          =>  Orders::STATUS_PENDING_SHIPMENT,
                    'amount'   =>  10000,
                ]
            )->assertStatus(302);

        $this->actingAs($this->admin, Admins::GUARDED)
            ->delete(route('orders.destroy', $id))->assertStatus(302);
    }
}
