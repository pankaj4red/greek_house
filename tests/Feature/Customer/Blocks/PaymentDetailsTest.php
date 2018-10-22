<?php

namespace Tests\Feature\Customer\Blocks;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class PaymentDetailsTest extends TestCase
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
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Payment Details');
        $response->assertSee('/dashboard/pblock/payment_details/' . $campaign->id . '/sales');
        $response->assertSee(route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]));
    }
    
    /**
     * @test
     */
    public function can_open_sales_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/payment_details/' . $campaign->id . '/sales');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('PAYMENT DETAILS');
        $response->assertSeeText('Download Order List');
        $response->assertSee('/report/campaign_sales/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_download_sales_report()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/dashboard/pblock/payment_details/' . $campaign->id . '/sales');
        
        // Execute
        $response->assertSee('/report/campaign_sales/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_cancel_order()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->post(route('customer_block_popup', ['payment_details', $campaign->id, 'close_date']), [
            'action' => 'cancel',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Cancelled');
    }
    
    /**
     * @test
     */
    public function can_close_order()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->post(route('customer_block_popup', ['payment_details', $campaign->id, 'close_date']), [
            'action' => 'close',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Successfully Closed');
        $campaign = $campaign->fresh();
        $this->assertEquals('processing_payment', $campaign->state);
    }
    
    /**
     * @test
     */
    public function can_extend_order()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->post(route('customer_block_popup', ['payment_details', $campaign->id, 'close_date']), [
            'action' => 'extend',
            'close_date' => Carbon::parse('+28 days')->format('m/d/Y'),
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Successfully Extended');
        $campaign = $campaign->fresh();
        $this->assertEquals(Carbon::parse('+28 days')->format('Y-m-d'), $campaign->close_date->format('Y-m-d'));
    }
}

