<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ApproveCampaignTest extends TestCase
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
        $manager = UserGenerator::create('account_manager')->user();
        $user = UserGenerator::create()->withAccountManager($manager)->user();
        $campaign = CampaignGenerator::create('campus_approval')->withOwner($user)->campaign();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/AccountManager');

        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Review');
        $response->assertSeeText('Approve Campaign');
    }
    
    /**
     * @test
     */
    public function can_submit_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $user = UserGenerator::create()->withAccountManager($manager)->user();
        $campaign = CampaignGenerator::create('campus_approval')->withOwner($user)->campaign();
        $this->be($manager);
        $response = $this->get('/campaign/' . $campaign->id . '/AccountManager');
        
        // Execute
        $response = $this->post(route('customer_block_popup',  ['approve_campaign', $campaign->id, 'approve']), [
            'save' => 'save',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/AccountManager');
        $response = $this->get('/campaign/' . $campaign->id . '/AccountManager');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Approved');
        $response->assertSeeText('Awaiting Design');
    }
}
