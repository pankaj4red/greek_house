<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class DesignGalleryTest extends TestCase
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
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/DesignGallery');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Design Gallery');
    }
    
    /**
     * @test
     */
    public function can_submit_block()
    {
        //TODO: Make more extensive testing.
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/DesignGallery');
        
        // Execute
        $response = $this->post(route('customer_block', ['design_gallery', $campaign->id]), [
            'name'   => $campaign->name,
            'code'   => $campaign->id,
            'status' => 'enabled',
            'images' => json_encode(['designs' => []]),
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/DesignGallery');
        $response = $this->get('/campaign/' . $campaign->id . '/DesignGallery');
        $response->assertStatus(200);
        $response->assertSeeText('Design Saved');
        $response->assertSeeText('Enabled');
        $campaign = $campaign->fresh();
        $this->assertEquals(1, $campaign->designs->count());
        $this->assertEquals(0, $campaign->designs->first()->active);
    }
}
