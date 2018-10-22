<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class NotesTest extends TestCase
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
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Designer & Support Notes');
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
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');

        // Execute
        $response = $this->post(route('customer_block', ['notes', $campaign->id]), [
            'notes' => 'Some support and designer notes',
        ]);

        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Notes Changed');
        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'notes' => 'Some support and designer notes',
        ]);
    }
}
