<?php

namespace Tests\Feature\Home;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_homepage()
    {
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertSee('Greek House');
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_see_refunds()
    {
        // Execute
        $response = $this->get('/refunds');
        
        // Assert
        $response->assertSee('Refunds & Returns');
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_see_tos()
    {
        // Execute
        $response = $this->get('/tos');
        
        // Assert
        $response->assertSee('TERMS OF SERVICE');
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_see_privacy()
    {
        // Execute
        $response = $this->get('/privacy');
        
        // Assert
        $response->assertSee('Privacy Policy');
        $response->assertStatus(200);
    }
}