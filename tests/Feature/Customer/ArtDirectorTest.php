<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ArtDirectorTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_art_director_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Art Director');
        $response->assertSee('/art-director');
    }
    
    /**
     * @test
     */
    public function can_see_art_director()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(6, (new Crawler($response->content()))->filter('.view_links_table a'));
        $response->assertSeeText('All');
        $response->assertSee('/art-director');
        $response->assertSeeText('Unclaimed Campaigns');
        $response->assertSee('/art-director/unclaimed');
        $response->assertSeeText('Awaiting for Designer');
        $response->assertSee('/art-director/awaiting_for_designer');
        $response->assertSeeText('Awaiting for Customer');
        $response->assertSee('/art-director/customer');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/art-director/files');
        $response->assertSeeText('Complete');
        $response->assertSee('/art-director/done');
        $this->assertCount(1, (new Crawler($response->content()))->filter('#unclaimed tbody tr'));
        $this->assertCount(2, (new Crawler($response->content()))->filter('#designer tbody tr'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('#customer tbody tr'));
        $this->assertCount(3, (new Crawler($response->content()))->filter('#files tbody tr'));
        $this->assertCount(8, (new Crawler($response->content()))->filter('#done tbody tr'));
        $response->assertSee('/art-director/designer');
    }
    
    /**
     * @test
     */
    public function can_see_art_director_unclaimed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/unclaimed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(6, (new Crawler($response->content()))->filter('.view_links_table a'));
        $response->assertSeeText('All');
        $response->assertSee('/art-director');
        $response->assertSeeText('Unclaimed Campaigns');
        $response->assertSee('/art-director/unclaimed');
        $response->assertSeeText('Awaiting for Designer');
        $response->assertSee('/art-director/awaiting_for_designer');
        $response->assertSeeText('Awaiting for Customer');
        $response->assertSee('/art-director/customer');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/art-director/files');
        $response->assertSeeText('Complete');
        $response->assertSee('/art-director/done');
        $this->assertCount(1, (new Crawler($response->content()))->filter('#unclaimed tbody tr'));
        $response->assertSeeText($campaign2->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_designer()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/awaiting_for_designer');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(6, (new Crawler($response->content()))->filter('.view_links_table a'));
        $response->assertSeeText('All');
        $response->assertSee('/art-director');
        $response->assertSeeText('Unclaimed Campaigns');
        $response->assertSee('/art-director/unclaimed');
        $response->assertSeeText('Awaiting for Designer');
        $response->assertSee('/art-director/awaiting_for_designer');
        $response->assertSeeText('Awaiting for Customer');
        $response->assertSee('/art-director/customer');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/art-director/files');
        $response->assertSeeText('Complete');
        $response->assertSee('/art-director/done');
        $this->assertCount(2, (new Crawler($response->content()))->filter('#designer tbody tr'));
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign5->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_customer()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/customer');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(6, (new Crawler($response->content()))->filter('.view_links_table a'));
        $response->assertSeeText('All');
        $response->assertSee('/art-director');
        $response->assertSeeText('Unclaimed Campaigns');
        $response->assertSee('/art-director/unclaimed');
        $response->assertSeeText('Awaiting for Designer');
        $response->assertSee('/art-director/awaiting_for_designer');
        $response->assertSeeText('Awaiting for Customer');
        $response->assertSee('/art-director/customer');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/art-director/files');
        $response->assertSeeText('Complete');
        $response->assertSee('/art-director/done');
        $this->assertCount(1, (new Crawler($response->content()))->filter('#customer tbody tr'));
        $response->assertSeeText($campaign4->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_files()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/files');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(6, (new Crawler($response->content()))->filter('.view_links_table a'));
        $response->assertSeeText('All');
        $response->assertSee('/art-director');
        $response->assertSeeText('Unclaimed Campaigns');
        $response->assertSee('/art-director/unclaimed');
        $response->assertSeeText('Awaiting for Designer');
        $response->assertSee('/art-director/awaiting_for_designer');
        $response->assertSeeText('Awaiting for Customer');
        $response->assertSee('/art-director/customer');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/art-director/files');
        $response->assertSeeText('Complete');
        $response->assertSee('/art-director/done');
        $this->assertCount(3, (new Crawler($response->content()))->filter('#files tbody tr'));
        $response->assertSeeText($campaign6->name);
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_done()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/done');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(6, (new Crawler($response->content()))->filter('.view_links_table a'));
        $response->assertSeeText('All');
        $response->assertSee('/art-director');
        $response->assertSeeText('Unclaimed Campaigns');
        $response->assertSee('/art-director/unclaimed');
        $response->assertSeeText('Awaiting for Designer');
        $response->assertSee('/art-director/awaiting_for_designer');
        $response->assertSeeText('Awaiting for Customer');
        $response->assertSee('/art-director/customer');
        $response->assertSeeText('Upload Files');
        $response->assertSee('/art-director/files');
        $response->assertSeeText('Complete');
        $response->assertSee('/art-director/done');
        $this->assertCount(8, (new Crawler($response->content()))->filter('#done tbody tr'));
        $response->assertSeeText($campaign9->name);
        $response->assertSeeText($campaign10->name);
        $response->assertSeeText($campaign11->name);
        $response->assertSeeText($campaign12->name);
        $response->assertSeeText($campaign13->name);
        $response->assertSeeText($campaign14->name);
        $response->assertSeeText($campaign15->name);
        $response->assertSeeText($campaign16->name);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_designer_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer1 = UserGenerator::create('designer')->user();
        $designer2 = UserGenerator::create('designer')->user();
        $designer3 = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('awaiting_design')->withOwner($user)->withDesigner($designer1)->campaign();
        $campaign4 = CampaignGenerator::create('awaiting_approval')->withOwner($user)->withDesigner($designer2)->campaign();
        $campaign5 = CampaignGenerator::create('revision_requested')->withOwner($user)->withDesigner($designer3)->campaign();
        $campaign6 = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer1)->campaign();
        $campaign7 = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer2)->campaign();
        $campaign8 = CampaignGenerator::create('processing_payment')->withOwner($user)->withDesigner($designer3)->campaign();
        $campaign9 = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->withDesigner($designer1)->campaign();
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer2)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer3)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer1)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer2)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer3)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer1)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer2)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/designer');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(3, (new Crawler($response->content()))->filter('#designers tbody tr'));
        $response->assertSee('/art-director/designer/' . $designer1->id);
        $response->assertSee('/art-director/designer/' . $designer2->id);
        $response->assertSee('/art-director/designer/' . $designer3->id);
    }
    
    /**
     * @test
     */
    public function can_see_art_director_designer_details()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $artDirector = UserGenerator::create('art_director')->user();
        $designer = UserGenerator::create('designer')->user();
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
        $campaign10 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign11 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign12 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign13 = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign14 = CampaignGenerator::create('shipped')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign15 = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        $campaign16 = CampaignGenerator::create('cancelled')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($artDirector);
        
        // Execute
        $response = $this->get('/art-director/designer/' . $designer->id);
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(14, (new Crawler($response->content()))->filter('#campaigns tbody tr'));
        $response->assertSeeText((string) $designer->id);
        $response->assertSeeText($designer->getFullName());
        $response->assertSeeText($designer->email);
        $response->assertSeeText($designer->phone);
    }
}