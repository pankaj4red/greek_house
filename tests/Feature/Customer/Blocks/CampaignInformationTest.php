<?php

namespace Tests\Feature\Customer\Blocks;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class CampaignInformationTest extends TestCase
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
        $campaign = CampaignGenerator::create('awaiting_approval', 'flexible')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Info');
        $response->assertSee('/dashboard/pblock/campaign_information/' . $campaign->id);
        $response->assertSeeText($campaign->user->getFullName());
        $response->assertSeeText($campaign->artwork_request->designer->getFullName());
        $response->assertSeeText($campaign->contact_school);
        $response->assertSeeText($campaign->contact_chapter);
        $response->assertSeeText('Flexible Within Timeframe');
        $response->assertSeeText($campaign->estimated_quantity);
        $response->assertSeeText($campaign->artwork_request->print_front_colors);
        $response->assertSeeText($campaign->artwork_request->print_front_description);
        $response->assertSeeText(design_style_preference_text($campaign->artwork_request->design_style_preference));
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
        $campaign = CampaignGenerator::create('claimed')->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/campaign_information/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText($campaign->artwork_request->print_front_description);
        $response->assertSee($campaign->artwork_request->designer->getFullName());
        $response->assertSee($campaign->promo_code);
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
        $campaign = CampaignGenerator::create('claimed')->withOwner($user)->campaign();
        $newDesigner = UserGenerator::create('designer')->user();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->post('/dashboard/pblock/campaign_information/' . $campaign->id, [
            'print_front'              => 'on',
            'print_front_colors'       => 4,
            'print_front_description'  => 'front description',
            'print_back'               => 'on',
            'print_back_colors'        => 1,
            'print_back_description'   => 'back description',
            'print_sleeve'             => 'on',
            'print_sleeve_colors'      => 1,
            'print_sleeve_description' => 'sleeve description',
            'print_sleeve_preferred'   => 'both',
            'designer_id'              => $newDesigner->id,
            'design_style_preference'  => 'graphic_stamp',
            'design_type'              => 'embroidery',
            'estimated_quantity'       => '144+',
            'promo_code'               => 'promo123',
            'date'                     => Carbon::parse('+15 weekdays')->format('m/d/Y'),
            'flexible'                 => 'no',
            'budget'                   => 'yes',
            'budget_range'             => '$15-$18',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Information Saved');
        $campaign = $campaign->fresh('artwork_request');
        
        $this->assertEquals(true, $campaign->artwork_request->print_front);
        $this->assertEquals(4, $campaign->artwork_request->print_front_colors);
        $this->assertEquals('front description', $campaign->artwork_request->print_front_description);
        $this->assertEquals(true, $campaign->artwork_request->print_back);
        $this->assertEquals(1, $campaign->artwork_request->print_back_colors);
        $this->assertEquals('back description', $campaign->artwork_request->print_back_description);
        $this->assertEquals(true, $campaign->artwork_request->print_sleeve);
        $this->assertEquals(1, $campaign->artwork_request->print_sleeve_colors);
        $this->assertEquals('sleeve description', $campaign->artwork_request->print_sleeve_description);
        $this->assertEquals('both', $campaign->artwork_request->print_sleeve_preferred);
        $this->assertEquals($newDesigner->id, $campaign->artwork_request->designer_id);
        $this->assertEquals('graphic_stamp', $campaign->artwork_request->design_style_preference);
        $this->assertEquals('embroidery', $campaign->artwork_request->design_type);
        $this->assertEquals('144+', $campaign->estimated_quantity);
        $this->assertEquals('promo123', $campaign->promo_code);
        $this->assertEquals(Carbon::parse('+15 weekdays')->format('m/d/Y'), $campaign->date->format('m/d/Y'));
        $this->assertEquals('no', $campaign->flexible);
        $this->assertEquals('yes', $campaign->budget);
        $this->assertEquals('$15-$18', $campaign->budget_range);
    }
}
