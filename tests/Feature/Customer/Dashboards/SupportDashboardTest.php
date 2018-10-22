<?php

namespace Tests\Feature\Customer\Dashboards;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class SupportDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_support_dashboard_open()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(14, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign4->name);
        $response->assertSeeText($campaign5->name);
        $response->assertSeeText($campaign6->name);
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
        $response->assertSeeText($campaign9->name);
        $response->assertSeeText($campaign10->name);
        $response->assertSeeText($campaign11->name);
        $response->assertSeeText($campaign12->name);
        $response->assertSeeText($campaign13->name);
        $response->assertSeeText($campaign14->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_on_hold()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/on_hold');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign1->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_design()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_design');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_approval()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_approval');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign4->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_revision()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/revision_requested');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign5->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_quote()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_quote');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign6->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_payment()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/collecting_payment');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_fulfillment_ready()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/fulfillment_ready');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign9->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_fulfillment_validation()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/fulfillment_validation');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign10->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_fulfillment_issue()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/fulfillment_issue');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign11->name);
        $response->assertSeeText($campaign12->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_printing()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/printing');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign13->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_shipped()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/shipped');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign14->name);
    }
    
    /**
     * @test
     */
    public function can_see_support_dashboard_closed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/dashboard/closed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(13, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('On Hold');
        $response->assertSee('/dashboard/on_hold');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Quote');
        $response->assertSee('/dashboard/awaiting_quote');
        $response->assertSeeText('Payment');
        $response->assertSee('/dashboard/collecting_payment');
        $response->assertSeeText('F. Ready');
        $response->assertSee('/dashboard/fulfillment_ready');
        $response->assertSeeText('F. Validation');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('F. Issue');
        $response->assertSee('/dashboard/fulfillment_issue');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Shipped');
        $response->assertSee('/dashboard/shipped');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign15->name);
        $response->assertSeeText($campaign16->name);
    }
}