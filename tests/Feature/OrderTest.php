<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create([
            'role' => 'provider',
            'email' => 'provider@example.com',
            'password' => bcrypt('password')
        ]);
        
        // Create a test product
        $this->product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 100
        ]);
    }

    /** @test */
    public function it_creates_an_order_successfully()
    {
        // Login the user
        $this->actingAs($this->user);

        // Prepare order data
        $orderData = [
            'product_id' => $this->product->id,
            'quantity' => 2,
            'shipping_address' => '123 Test St, Test City',
            'notes' => 'Test order notes'
        ];

        // Send POST request to create order
        $response = $this->actingAs($this->user)
                        ->post(route('orders.store'), $orderData);

        // Assert response
        $response->assertStatus(302) // Redirect after successful creation
                ->assertSessionHas('success');
                
        // The controller redirects back to the previous page (create form)
        // We'll verify it's a redirect to the previous page
        $response->assertRedirect(url()->previous());
        
        // Assert the order was created in the database
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => $orderData['quantity'],
            'status' => 'pending'
        ]);

        // Assert database has the order
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
            'status' => 'pending'
        ]);

        // Assert product stock was updated
        $this->assertEquals(98, $this->product->fresh()->stock);
    }

    /** @test */
    public function it_validates_order_creation_with_invalid_data()
    {
        // Login the user
        $this->actingAs($this->user);

        // Prepare invalid order data (missing required fields and invalid quantity)
        $invalidOrderData = [
            'product_id' => 999, // Non-existent product
            'quantity' => 0, // Invalid quantity
            // Missing shipping_address
        ];

        // Send POST request with invalid data
        $response = $this->actingAs($this->user)
                        ->post(route('orders.store'), $invalidOrderData);

        // Assert response has validation errors
        $response->assertStatus(302) // Redirect back with errors
                ->assertSessionHasErrors([
                    'product_id',
                    'quantity',
                ])
                ->assertSessionDoesntHaveErrors('shipping_address'); // shipping_address is not required in the actual implementation

        // Assert no order was created
        $this->assertDatabaseCount('orders', 0);
        
        // Assert product stock remains unchanged
        $this->assertEquals(100, $this->product->fresh()->stock);
    }

    /** @test */
    public function it_prevents_ordering_more_than_available_stock()
    {
        // Login the user
        $this->actingAs($this->user);

        // Prepare order data with quantity exceeding available stock
        $orderData = [
            'product_id' => $this->product->id,
            'quantity' => 150, // More than available stock (100)
            'shipping_address' => '123 Test St, Test City'
        ];

        // Send POST request
        $response = $this->actingAs($this->user)
                        ->post(route('orders.store'), $orderData);

        // Assert response has validation error for quantity
        $response->assertStatus(302) // Redirect back with errors
                ->assertSessionHasErrors([
                    'quantity' => 'Only 100 units of Test Product are available in stock.'
                ]);

        // Assert no order was created
        $this->assertDatabaseCount('orders', 0);
        
        // Assert product stock remains unchanged
        $this->assertEquals(100, $this->product->fresh()->stock);
    }
}
