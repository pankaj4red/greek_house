<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ShippingInformationTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Shipping Info');
        $response->assertSee('/dashboard/pblock/shipping_information/' . $campaign->id);
        $response->assertSeeText($campaign->address_line1);
        $response->assertSeeText($campaign->address_line2);
        $response->assertSeeText($campaign->address_city);
        $response->assertSeeText($campaign->address_state);
        $response->assertSeeText($campaign->address_zip_code);
    }
    
    /**
     * @test
     */
    public function can_open_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->get('/dashboard/pblock/shipping_information/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('SHIPPING INFORMATION');
    }
    
    /**
     * @test
     */
    public function can_submit_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->post('/dashboard/pblock/shipping_information/' . $campaign->id, [
            'address_line1'    => 'my address line 1',
            'address_line2'    => 'my address line 2',
            'address_city'     => 'my address city',
            'address_state'    => 'my address state',
            'address_zip_code' => '10000',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Customer');
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        $response->assertStatus(200);
        $response->assertSeeText('Shipping Information Saved');
        $campaign = $campaign->fresh();
        $this->assertDatabaseHas('campaigns', [
            'id'               => $campaign->id,
            'address_line1'    => 'my address line 1',
            'address_line2'    => 'my address line 2',
            'address_city'     => 'my address city',
            'address_state'    => 'my address state',
            'address_zip_code' => '10000',
        ]);
    }
}
