<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->user = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        
        // Set the authenticated user
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_display_products_index_page()
    {
        $response = $this->actingAs($this->user)
                        ->get(route('products.index'));

        $response->assertStatus(200)
                ->assertViewIs('products.index')
                ->assertViewHas('products');
    }

    /** @test */
    public function it_can_display_create_product_page()
    {
        $response = $this->actingAs($this->user)
                        ->get(route('products.create'));

        $response->assertStatus(200)
                ->assertViewIs('products.create');
    }

    /** @test */
    public function it_can_store_a_valid_product()
    {
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 99.99,
            'stock' => 100
        ];

        $response = $this->post(route('products.store'), $productData);

        $response->assertStatus(302)
                ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 100
        ]);
    }

    /** @test */
    public function it_validates_product_creation()
    {
        $invalidProductData = [
            'name' => '',
            'price' => 'invalid',
            'stock' => -5,
            // Missing required fields
        ];

        $response = $this->post(route('products.store'), $invalidProductData);

        $response->assertStatus(302)
                ->assertSessionHasErrors([
                    'name',
                    'price',
                    'stock'
                ]);
    }

    /** @test */
    public function it_can_display_edit_product_page()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
                        ->get(route('products.edit', $product));

        $response->assertStatus(200)
                ->assertViewIs('products.edit')
                ->assertViewHas('product', $product);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create([
            'name' => 'Original Product',
            'price' => 50.00,
            'stock' => 50
        ]);

        $updateData = [
            'name' => 'Updated Product Name',
            'price' => 149.99,
            'stock' => 75
        ];

        $response = $this->put(route('products.update', $product), $updateData);

        $response->assertStatus(302)
                ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'price' => 149.99,
            'stock' => 75
        ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create([
            'name' => 'Product to delete',
            'price' => 99.99,
            'stock' => 10
        ]);

        $response = $this->delete(route('products.destroy', $product));

        $response->assertStatus(302)
                ->assertSessionHas('success');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function it_prevents_unauthorized_access()
    {
        // Create a non-admin user
        $user = User::factory()->create(['role' => 'provider']);
        $product = Product::factory()->create();

        // Test create page
        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertStatus(403);

        // Test store
        $this->actingAs($user)
            ->post(route('products.store'), [])
            ->assertStatus(403);

        // Test edit page
        $this->actingAs($user)
            ->get(route('products.edit', $product))
            ->assertStatus(403);

        // Test update
        $this->actingAs($user)
            ->put(route('products.update', $product), [])
            ->assertStatus(403);

        // Test delete
        $this->actingAs($user)
            ->delete(route('products.destroy', $product))
            ->assertStatus(403);
    }
}
