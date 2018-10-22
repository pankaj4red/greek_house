<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class AccountManagerNotesTest extends TestCase
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
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/AccountManager');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campus Manager Notes');
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
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $this->be($manager);
        $response = $this->get('/campaign/' . $campaign->id . '/AccountManager');

        // Execute
        $response = $this->post(route('customer_block', ['account_manager_notes', $campaign->id]), [
            'account_manager_notes' => 'An account manager notes',
        ]);

        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/AccountManager');
        $response = $this->get('/campaign/' . $campaign->id . '/AccountManager');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Account Manager Notes Changed');
        $response->assertSeeText('An account manager notes');
    }
}
