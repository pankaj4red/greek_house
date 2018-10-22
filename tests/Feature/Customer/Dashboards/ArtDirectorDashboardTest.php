<?php

namespace Tests\Feature\Customer\Dashboards;

use App\Helpers\OnHold\RejectedByDesignerGenericRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ArtDirectorDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_unclaimed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer)->campaign();
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
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign2->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_open()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('claimed')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/open');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(10, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
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
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_design()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_design');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign3->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_approval()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/awaiting_approval');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign4->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_revision()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/revision_requested');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign5->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_upload_files()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/upload_print_files');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(3, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign6->name);
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_artwork_revision()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/fulfillment_artwork_failed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign12->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_dashboard_closed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $director = UserGenerator::create('art_director')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($director)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($director)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($director)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($director)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($director)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($director)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($director)->withDecorator($decorator)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($director)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/dashboard/closed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(8, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Unclaimed');
        $response->assertSee('/dashboard/unclaimed');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Design');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Approval');
        $response->assertSee('/dashboard/awaiting_design');
        $response->assertSeeText('Revision');
        $response->assertSee('/dashboard/revision_requested');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/dashboard/upload_print_files');
        $response->assertSeeText('Artwork Revision');
        $response->assertSee('/dashboard/fulfillment_artwork_failed');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(5, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign10->name);
        $response->assertSeeText($campaign13->name);
        $response->assertSeeText($campaign14->name);
        $response->assertSeeText($campaign15->name);
        $response->assertSeeText($campaign16->name);
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
        $designer = UserGenerator::create('art_director')->user();
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
        $designer = UserGenerator::create('art_director')->user();
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
        $designer = UserGenerator::create('art_director')->user();
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
        $designer = UserGenerator::create('art_director')->user();
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