<?php

namespace Tests\Feature\Customer\Dashboards;

use App\Helpers\OnHold\RejectedByDesignerGenericRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class DesignerDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_unclaimed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/closed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
    }
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_open()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard/open');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Upload Files');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(4, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign4->name);
        $response->assertSeeText($campaign5->name);
        $response->assertSeeText($campaign6->name);
    }
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_design()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_design');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign4->name);
    }
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_approval()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_approval');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign5->name);
    }
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_revision()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard/revision_requested');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign6->name);
    }
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_upload_print()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign(['state' => 'cancelled']);
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard/upload_print_files');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(3, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
    }
    
    /**
     * @test
     */
    public function can_see_designer_dashboard_closed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard/closed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(7, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_approval');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
    }
    
    /**
     * @test
     */
    public function can_see_grab_campaigns()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertSee('/grab-campaign/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_grab_campaigns()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $this->be($designer);
        $response = $this->get('/dashboard');
        
        // Execute
        $response = $this->get('/grab-campaign/' . $campaign->id);
        
        // Assert
        $response->assertRedirect('/dashboard');
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSeeText('This campaign is now assigned to you');
        $campaign = $campaign->fresh('artwork_request');
        $this->assertEquals($designer->id, $campaign->artwork_request->designer_id);
    }
    
    /**
     * @test
     */
    public function can_see_reject_campaigns()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertSee('/reject-campaign/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_reject_campaigns()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $this->be($designer);
        $response = $this->get('/dashboard');
        
        // Execute
        $response = $this->post('/reject-campaign/' . $campaign->id, [
            'reason' => 'generic',
        ]);
        
        // Assert
        $response->assertRedirect('/dashboard');
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSeeText('This campaign is now marked as rejected by you');
        $campaign = $campaign->fresh();
        $this->assertEquals('on_hold', $campaign->state);
        $this->assertEquals('design', $campaign->on_hold_category);
        $this->assertEquals(RejectedByDesignerGenericRule::class, $campaign->on_hold_rule);
        $this->assertEquals($designer->id, $campaign->on_hold_actor);
    }
}