<?php

namespace Tests\Feature;

use App\Models\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{

    public function testGetOrderById()
    {
        $order = 1; 
        $response = $this->json('GET', '/api/orders/' . $order);
        $response->assertStatus(200);
    }

    public function testCreateOrder()
    {
        $data = ['product_id' => 1, 'quantity' => 2];
        $response = $this->json('POST', '/api/orders', $data);
        $response->assertStatus(201);
    }
}
