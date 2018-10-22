<?php

namespace Tests\Feature\Customer\Modules;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class CampaignDetailsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_module()
    {
        //TODO
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
        $response->assertSeeText('Description');
    }
}
