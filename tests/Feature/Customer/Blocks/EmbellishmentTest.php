<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class EmbellishmentTest extends TestCase
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
        $campaign = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Embellishment');
        $response->assertSee('/dashboard/pblock/embellishment/' . $campaign->id);
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
        $campaign = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/embellishment/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Embellishment');
        $response->assertSee('/dashboard/pblock/embellishment/' . $campaign->id);
        $response->assertSee($campaign->artwork_request->design_type == 'screen' ? 'Screenprint' : 'Embroidery');
        $response->assertSee($campaign->polybag_and_label ? 'yes' : 'no');
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
        $campaign = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->post('/dashboard/pblock/embellishment/' . $campaign->id, [
            'design_type'       => 'embroidery',
            'polybag_and_label' => 'no',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Embellishment Updated');
        $campaign = $campaign->fresh('artwork_request');
        $this->assertEquals('embroidery', $campaign->artwork_request->design_type);
        $this->assertEquals('no', $campaign->polybag_and_label ? 'yes' : 'no');
    }
}
