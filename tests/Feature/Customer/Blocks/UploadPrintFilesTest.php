<?php

namespace Tests\Feature\Customer\Blocks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class UploadPrintFilesTest extends TestCase
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
        $director = UserGenerator::create('art_director')->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($director);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Director');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Upload Print Files & Order Forms(s)');
        $response->assertSeeText('No print files were uploaded.');
        $response->assertSeeText('Order List');
        $response->assertSee('/report/campaign_sales/' . $campaign->id);
        $response->assertSee('/dashboard/cblock/upload_print_files/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_submit_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $director = UserGenerator::create('art_director')->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($director);
        $response = $this->get('/campaign/' . $campaign->id . '/Director');
        
        // Execute
        $response = $this->post('/dashboard/cblock/upload_print_files/' . $campaign->id, [
            'print_file' => UploadedFile::fake()->image('avatar.jpg'),
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Director');
        $response = $this->get('/campaign/' . $campaign->id . '/Director');
        $response->assertStatus(200);
        $response->assertSeeText('Print File associated with campaign');
        $response->assertSeeText('avatar.jpg');
    }
    
    /**
     * @test
     */
    public function can_solve_artwork_issue()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('invalid_artwork', 'non_flexible')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $this->assertEquals(false, $campaign->fulfillment_valid ? true : false);
        
        // Execute
        $response = $this->post('/dashboard/cblock/upload_print_files/' . $campaign->id, [
            'print_file' => UploadedFile::fake()->image('avatar.jpg'),
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Fulfillment Artwork Issue marked as Solved');
        $campaign = $campaign->fresh();
        $this->assertEquals(true, $campaign->fulfillment_valid ? true : false);
    }
    
    //TODO: Enable tests with Excel generation
    public function can_download_order_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/report/campaign_sales/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
    }
    
    //TODO: Enable tests with CSV generation
    public function can_download_shipping_csv()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/report/campaign_shipping_file/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
    }
    
    //TODO: Enable tests with PDF generation
    public function can_download_shipping_pdf()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create('awaiting_quote')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/report/campaign_shipping_pdf/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
    }
}
