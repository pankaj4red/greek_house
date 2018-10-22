<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_referral_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $user = UserGenerator::create()->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Refer A Friend');
        $response->assertSee('/referrals');
    }
    
    /**
     * @test
     */
    public function can_see_referral()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $user = UserGenerator::create()->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/referrals');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('/work-with-us/sales/' . $user->id);
    }
}