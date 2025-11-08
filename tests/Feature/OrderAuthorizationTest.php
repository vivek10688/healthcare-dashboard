<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_dispatch_order()
    {
        $provider = User::factory()->create(['role' => 'provider']);
        $order = Order::factory()->create();

        $response = $this->actingAs($provider)->post(route('orders.dispatch', $order));

        $response->assertStatus(403);
    }
}
