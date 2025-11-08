<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_order_more_than_available_stock()
    {
        $product = Product::factory()->create(['stock' => 5]);
        $user = User::factory()->create(['role' => 'provider']);

        $this->actingAs($user);

        $response = $this
            ->actingAs($user)
            ->postJson(route('orders.store'), [
                'product_id' => $product->id,
                'quantity' => 10,
            ]);

        $response->assertStatus(422);
    }

    public function test_prevents_overselling_and_rolls_back_on_failure()
    {
        $product = Product::factory()->create(['stock' => 5]);
        $user = User::factory()->create(['role' => 'provider']);

        try {
            app(\App\Services\OrderService::class)->createOrder([
                'product_id' => $product->id,
                'quantity' => 10,
            ], $user);
        } catch (\Exception $e) {
            // expected
        }

        $product->refresh();
        $this->assertEquals(5, $product->stock, 'Stock should remain unchanged');
    }
}
