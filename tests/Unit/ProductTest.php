<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{

    public function testGetAllProducts()
    {
        $response = $this->json('GET', '/api/products');
        $response->assertStatus(200);
    }

    public function testGetProductById()
    {
        $product = 1;
        $response = $this->json('GET', '/api/products/' . $product);
        $response->assertStatus(200);
    }

    public function testCreateProduct()
    {
        $data = ['name' => 'Product Name', 'price' => 100, 'inventory' => 50];
        $response = $this->json('POST', '/api/products', $data);
        $response->assertStatus(201);
    }

    public function testUpdateProduct()
    {
        $product = 1;
        $data = ['name' => 'New Product Name', 'price' => 200, 'inventory' => 30];
        $response = $this->json('PUT', '/api/products/' . $product, $data);
        $response->assertStatus(200);
    }

    public function testDeleteProduct()
    {
        $product = 2;
        $response = $this->json('DELETE', '/api/products/' . $product);
        $response->assertStatus(200);
    }
}
