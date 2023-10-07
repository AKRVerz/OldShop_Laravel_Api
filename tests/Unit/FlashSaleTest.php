<?php

namespace Tests\Feature;

use Tests\TestCase;

class FlashSaleTest extends TestCase
{

    public function testFlashSaleEndpoint()
    {
        $productId = 1;
        $response = $this->json('POST', '/api/flash-sale/' . $productId, ['key' => 'value']);
        $response->assertStatus(200);
    }
}
