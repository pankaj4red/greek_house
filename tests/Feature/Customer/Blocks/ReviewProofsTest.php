<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ReviewProofsTest extends TestCase
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
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($user);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Uploaded Proofs');
        $response->assertSee('/dashboard/pblock/review_proofs/' . $campaign->id . '/request_revision');
        $response->assertSee('/dashboard/pblock/review_proofs/' . $campaign->id . '/approve_design');
    }
    
    /**
     * @test
     */
    public function can_open_request_revision_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->get('/dashboard/pblock/review_proofs/' . $campaign->id . '/request_revision');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('MAKE CHANGES');
    }
    
    /**
     * @test
     */
    public function can_submit_request_revision_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->post('/dashboard/pblock/review_proofs/' . $campaign->id . '/request_revision', [
            'revision_text' => 'This design needs a revision',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Customer');
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        $response->assertStatus(200);
        $response->assertDontSeeText('MAKE CHANGES');
        $campaign = $campaign->fresh();
        $this->assertEquals('revision_requested', $campaign->state);
        $this->assertEquals('This design needs a revision', $campaign->artwork_request->revision_text);
    }
    
    /**
     * @test
     */
    public function can_open_approve_design_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->get('/dashboard/pblock/review_proofs/' . $campaign->id . '/approve_design');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('APPROVE DESIGN');
    }
    
    /**
     * @test
     */
    public function can_submit_awaiting_design_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($user);
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        
        // Execute
        $response = $this->post('/dashboard/pblock/review_proofs/' . $campaign->id . '/approve_design');
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Customer');
        $response = $this->get('/campaign/' . $campaign->id . '/Customer');
        $response->assertStatus(200);
        $response->assertSeeText('Designs have been approved');
        $campaign = $campaign->fresh();
        $this->assertEquals('awaiting_quote', $campaign->state);
    }
}
