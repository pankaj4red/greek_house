<?php

namespace Tests\Feature\Customer\Blocks;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class CustomerPromiseTest extends TestCase
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
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Customer Promise');
        $response->assertSeeText('Assigned On');
        $response->assertSeeText('Rush Order');
        $response->assertSeeText('Printing Date');
        $response->assertSeeText('Due Date');
        $response->assertSeeText('Flexible');
        $response->assertSee('/dashboard/pblock/customer_promise/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_open_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/customer_promise/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Customer Promise');
        $response->assertSeeText('Rush');
        $response->assertSeeText('Delivery Due Date');
        $response->assertSeeText('Flexibility');
    }
    
    /**
     * @test
     */
    public function can_submit_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->post('/dashboard/pblock/customer_promise/' . $campaign->id, [
            'rush'     => 'yes',
            'date'     => Carbon::parse('+12 weekdays')->format('m/d/Y'),
            'flexible' => 'no',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Customer Promise Updated');
        $this->assertDatabaseHas('campaigns', [
            'id'       => $campaign->id,
            'rush'     => true,
            'date'     => Carbon::parse('+12 weekdays')->format('Y-m-d 00:00:00'),
            'flexible' => 'no',
        ]);
    }
}
