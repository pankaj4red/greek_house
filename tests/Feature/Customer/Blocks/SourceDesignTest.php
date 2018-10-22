<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class SourceDesignTest extends TestCase
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
        $campaign = CampaignGenerator::create()->withSourceDesign()->withOwner($user)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Source Design');
        $response->assertSeeText($campaign->source_design->name);
        foreach ($campaign->source_design->images as $image) {
            $response->assertSee(route('system::image', [$image->file_id]));
        }
    }
    
    /**
     * @test
     */
    public function cannot_see_block_if_no_source_design()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Source Design');
    }
}
