<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($user);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Messages');
    }
    
    /**
     * @test
     */
    public function can_submit_text_on_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->post(route('customer_block', ['messages', $campaign->id]), [
            'channel' => 'customer',
            'body'    => 'New comment text',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Customer');
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        $response->assertStatus(200);
        $response->assertSeeText('Message Posted');
        $response->assertSeeText('New comment text');
    }
    
    /**
     * @test
     */
    public function can_submit_image_on_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->post(route('customer_block', ['messages', $campaign->id]), array_merge([
            'channel' => 'customer',
            'body'    => 'New comment text',
        ], $this->attachFile('file')));
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Customer');
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        $response->assertStatus(200);
        $response->assertSeeText('Message Posted');
    }
}
