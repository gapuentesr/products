<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'code' => '001',
            'name' => 'Producto 1',
            'price' => 100,
            'description' => 'Descripción para el Producto 1',
            'quantity' => 10,
        ];

        $response = $this->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'code' => '002',
            'name' => 'Producto Actualizado',
            'price' => 150,
            'description' => 'Descripción actualizada',
            'quantity' => 15,
        ];

        $response = $this->put(route('products.update', $product->id), $updatedData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index'));
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
