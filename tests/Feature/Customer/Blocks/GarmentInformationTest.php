<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class GarmentInformationTest extends TestCase
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
        $this->be($user);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Garment Info');
        $response->assertSeeText($campaign->product_colors->first()->product->name);
        $response->assertSeeText($campaign->product_colors->first()->product->category->name);
        $response->assertSeeText($campaign->product_colors->first()->product->style_number);
        $response->assertSeeText($campaign->product_colors->first()->name);
    }
}
