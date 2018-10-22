<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ProvideQuoteTest extends TestCase
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
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);

        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');

        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Provide Quote');
        $response->assertSeeText('$0.00');
        $response->assertSee('/dashboard/pblock/provide_quote/' . $campaign->id);
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
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');

        // Execute
        $response = $this->get('/dashboard/pblock/provide_quote/' . $campaign->id);

        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('PROVIDE QUOTE');
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
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');

        // Execute
        $response = $this->post('/dashboard/pblock/provide_quote/' . $campaign->id, [
            'estimated_quantity' => '72-143',
            'design_hours'       => '3:40',
            'markup'             => '60',
            'unit_price_low'     => ['$20.00', '$18.00'],
            'unit_price_high'    => ['$25.00', '$28.00'],
            'product_id'         => [$campaign->product_colors->first()->product_id, 1],
        ]);

        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('A quote has been provided');
        $response->assertSeeText('[$20.00 - $25.00]');
        $response->assertSeeText('[$18.00 - $28.00]');
        $response->assertSeeText('72-143');
        $campaign = $campaign->fresh();
        $this->assertEquals(220, $campaign->artwork_request->design_minutes);
        $this->assertEquals(60, $campaign->markup);
    }
}

