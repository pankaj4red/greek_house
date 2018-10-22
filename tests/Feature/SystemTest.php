<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_get_product_colors()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $product = product_repository()->first();
        
        // Execute
        $response = $this->get('/product-colors/' . $product->id);
        
        // Assert
        $response->assertStatus(200);
        $result = json_decode($response->getContent());
        
        $this->assertTrue($result->success);
        $this->assertEquals($product->colors->count(), count($result->colors));
    }
}