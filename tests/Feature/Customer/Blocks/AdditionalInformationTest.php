<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class AdditionalInformationTest extends TestCase
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
        $response->assertSeeText('Shipping Cost');
        $response->assertSee('/dashboard/pblock/additional_information/' . $campaign->id);
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
        $response = $this->get('/dashboard/pblock/additional_information/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Shipping Cost');
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
        $response = $this->post(route('customer_block_popup',  ['additional_information', $campaign->id]), [
            'shipping_cost' => 15.62,
        ]);

        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Additional Information Updated');
        $response->assertSeeText('15.62');
    }
}
