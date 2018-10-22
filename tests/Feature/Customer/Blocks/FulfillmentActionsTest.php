<?php

namespace Tests\Feature\Customer\Blocks;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class FulfillmentActionsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Fulfillment Actions');
        $response->assertSee('/dashboard/pblock/fulfillment_actions/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_open_report_issue_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->get('/dashboard/pblock/fulfillment_actions/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('REPORT ISSUE');
    }
    
    /**
     * @test
     */
    public function can_submit_report_issue_popup_artwork_bad()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post('/dashboard/pblock/fulfillment_actions/' . $campaign->id, [
            'reason'      => 'Artwork',
            'description' => 'Wrong file types',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Issue Reported');
        $this->assertDatabaseHas('campaigns', [
            'id'                         => $campaign->id,
            'fulfillment_valid'          => false,
            'fulfillment_invalid_reason' => 'Artwork',
            'fulfillment_invalid_text'   => 'Wrong file types',
        ]);
    }
    
    /**
     * @test
     */
    public function can_submit_report_issue_popup_garment_bad()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post('/dashboard/pblock/fulfillment_actions/' . $campaign->id, [
            'reason'      => 'Garment',
            'description' => 'Garments out of stock',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Issue Reported');
        $this->assertDatabaseHas('campaigns', [
            'id'                         => $campaign->id,
            'fulfillment_valid'          => false,
            'fulfillment_invalid_reason' => 'Garment',
            'fulfillment_invalid_text'   => 'Garments out of stock',
        ]);
    }
    
    /**
     * @test
     */
    public function can_submit_report_issue_popup_other()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post('/dashboard/pblock/fulfillment_actions/' . $campaign->id, [
            'reason'      => 'Other',
            'description' => 'Something else is wrong',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Issue Reported');
        $this->assertDatabaseHas('campaigns', [
            'id'                         => $campaign->id,
            'fulfillment_valid'          => false,
            'fulfillment_invalid_reason' => 'Other',
            'fulfillment_invalid_text'   => 'Something else is wrong',
        ]);
    }
    
    /**
     * @test
     */
    public function can_see_block_with_issue()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Issue: Garment');
        $response->assertSeeText($campaign->fulfillment_invalid_text);
        $response->assertSee('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/issue_solved');
    }
    
    /**
     * @test
     */
    public function can_see_solve_issue_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->get('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/issue_solved');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('ISSUE SOLVED');
    }
    
    /**
     * @test
     */
    public function can_submit_solve_issue_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/issue_solved');
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Issue Reported as Solved');
    }
    
    /**
     * @test
     */
    public function can_set_print_date()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post(route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'fulfillment_printing_date']), [
            'printing_date' => Carbon::parse('+6 weekdays')->format('m/d/Y'),
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $this->assertDatabaseHas('campaigns', [
            'id'            => $campaign->id,
            'state'         => 'printing',
            'printing_date' => Carbon::parse('+6 weekdays')->format('Y-m-d 00:00:00'),
        ]);
    }
    
    /**
     * @test
     */
    public function can_see_printing_state_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Update');
        $response->assertSeeText('Mark as Shipped');
        $response->assertSeeText($campaign->printing_date->format('m/d/Y'));
        $response->assertSee('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/mark_shipped');
    }
    
    /**
     * @test
     */
    public function can_update_printing_date()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post(route('customer_block_popup', ['fulfillment_actions', $campaign->id, 'fulfillment_printing_date']), [
            'printing_date' => Carbon::parse('+16 weekdays')->format('m/d/Y'),
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Printing date set');
        $campaign = $campaign->fresh();
        $this->assertDatabaseHas('campaigns', [
            'id'            => $campaign->id,
            'printing_date' => Carbon::parse('+16 weekdays')->format('Y-m-d 00:00:00'),
        ]);
    }
    
    /**
     * @test
     */
    public function can_open_mark_as_shipped_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->get('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/mark_shipped');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('SHIPPING DETAILS');
    }
    
    /**
     * @test
     */
    public function can_submit_mark_as_shipped_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/mark_shipped', [
            'tracking_code'  => 'xyz',
            'scheduled_date' => Carbon::parse('+10 weekdays')->format('m/d/Y'),
            'invoice_total'  => 452.51,
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Shipping Details Saved');
        $this->assertDatabaseHas('campaigns', [
            'id'             => $campaign->id,
            'state'          => 'shipped',
            'scheduled_date' => Carbon::parse('+10 weekdays')->format('Y-m-d 00:00:00'),
            'invoice_total'  => 452.51,
            'tracking_code'  => 'xyz',
        ]);
    }
    
    /**
     * @test
     */
    public function can_mark_as_delivered()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $campaign = CampaignGenerator::create('shipped')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($decorator);
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        
        // Execute
        $response = $this->post('/dashboard/pblock/fulfillment_actions/' . $campaign->id . '/fulfillment_state', [
            'fulfillment_state' => 'delivered',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Decorator');
        $response = $this->get('/campaign/' . $campaign->id . '/Decorator');
        $response->assertStatus(200);
        $response->assertSeeText('Fulfillment state set');
        $this->assertDatabaseHas('campaigns', [
            'id'    => $campaign->id,
            'state' => 'delivered',
        ]);
    }
}
