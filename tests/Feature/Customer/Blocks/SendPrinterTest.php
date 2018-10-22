<?php

namespace Tests\Feature\Customer\Blocks;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class SendPrinterTest extends TestCase
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
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('SEND TO DECORATOR');
        $response->assertSee('/dashboard/pblock/send_printer/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_open_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('fulfillment_ready', 'non_flexible')->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/send_printer/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Assign to Decorator');
        
        $response->assertSee($campaign->product_colors->first()->name);
        $response->assertSee(product_color($campaign->product_colors->first()->pivot->color_id)->name);
        $response->assertSee($campaign->getContactFullName());
        $response->assertSee($campaign->address_line1);
        $response->assertSee($campaign->address_line2);
        $response->assertSee($campaign->address_city);
        $response->assertSee($campaign->address_state);
        $response->assertSee($campaign->address_zip_code);
    }
    
    /**
     * @test
     */
    public function can_submit_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('fulfillment_ready', 'non_flexible')->withOwner($user)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $sizes = [];
        foreach ($campaign->orders as $order) {
            $sizeEntry = [];
            foreach ($campaign->product_colors->first()->product->sizes as $size) {
                $sizeEntry[$size->size->short] = 0;
            }
            foreach ($order->entries as $entry) {
                $sizeEntry[$entry->size->short] += $entry->quantity;
            }
        }
        $defaultDueDate = $campaign->flexible == 'no' ? date('m/d/Y', strtotime($campaign->date)) : Carbon::parse('+ 10 weekdays')->format('m/d/Y');;
        $response = $this->post('/dashboard/pblock/send_printer/' . $campaign->id, [
            'design_type'                   => $campaign->artwork_request->design_type,
            'polybag_and_label'             => $campaign->polybag_and_label ? 'yes' : 'no',
            'fulfillment_shipping_name'     => $campaign->fulfillment_shipping_name ?? $campaign->contact_first_name . ' ' . $campaign->contact_last_name,
            'fulfillment_shipping_phone'    => $campaign->fulfillment_shipping_phone ?? $campaign->contact_phone,
            'fulfillment_shipping_line1'    => $campaign->fulfillment_shipping_line1 ?? $campaign->address_line1,
            'fulfillment_shipping_line2'    => $campaign->fulfillment_shipping_line2 ?? $campaign->address_line2,
            'fulfillment_shipping_city'     => $campaign->fulfillment_shipping_city ?? $campaign->address_city,
            'fulfillment_shipping_state'    => $campaign->fulfillment_shipping_state ?? $campaign->address_state,
            'fulfillment_shipping_zip_code' => $campaign->fulfillment_shipping_zip_code ?? $campaign->address_zip_code,
            'rush'                          => $campaign->rush ? 'yes' : 'no',
            'flexible'                      => $campaign->flexible,
            'due_at'                        => $defaultDueDate,
            'decorator_pocket'              => $campaign->decorator_pocket,
            'speciality_inks'               => $campaign->artwork_request->speciality_inks,
            'embellishment_names'           => $campaign->artwork_request->embellishment_names,
            'embellishment_numbers'         => $campaign->artwork_request->embellishment_numbers,
            'garment_arrival_date'          => Carbon::parse('+8 weekdays')->format('m/d/Y'),
            'printing_date'                 => Carbon::parse('+9 weekdays')->format('m/d/Y'),
            'days_in_transit'               => 3,
            'decorator'                     => $decorator->id,
            'sizes'                         => json_encode([
                ['id' => 0, 'sizes' => $sizes, 'supplier' => 22, 'eta' => '', 'ship_from' => '', 'quantity' => 75, 'total' => 0],
            ]),
            'shipping_option'               => 'fedex_2_day',
        ]);
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response->assertStatus(200);
        $response->assertSeeText('Campaign Associated with Decorator');
        $campaign = $campaign->fresh();
        $this->assertEquals('fulfillment_validation', $campaign->state);
    }
    
    /**
     * @test
     */
    public function can_solve_garment_issue()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('invalid_garment', 'non_flexible')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        $response = $this->get('/dashboard/pblock/send_printer/' . $campaign->id);
        $this->assertEquals(false, $campaign->fulfillment_valid ? true : false);
        
        // Execute
        $sizes = [];
        foreach ($campaign->orders as $order) {
            $sizeEntry = [];
            foreach ($campaign->product_colors->first()->product->sizes as $size) {
                $sizeEntry[$size->size->short] = 0;
            }
            foreach ($order->entries as $entry) {
                $sizeEntry[$entry->size->short] += $entry->quantity;
            }
        }
        $defaultDueDate = $campaign->flexible == 'no' ? date('m/d/Y', strtotime($campaign->date)) : Carbon::parse('+ 10 weekdays')->format('m/d/Y');;
        $response = $this->post('/dashboard/pblock/send_printer/' . $campaign->id, [
            'design_type'                   => $campaign->artwork_request->design_type,
            'polybag_and_label'             => $campaign->polybag_and_label ? 'yes' : 'no',
            'fulfillment_shipping_name'     => $campaign->fulfillment_shipping_name ?? $campaign->contact_first_name . ' ' . $campaign->contact_last_name,
            'fulfillment_shipping_phone'    => $campaign->fulfillment_shipping_phone ?? $campaign->contact_phone,
            'fulfillment_shipping_line1'    => $campaign->fulfillment_shipping_line1 ?? $campaign->address_line1,
            'fulfillment_shipping_line2'    => $campaign->fulfillment_shipping_line2 ?? $campaign->address_line2,
            'fulfillment_shipping_city'     => $campaign->fulfillment_shipping_city ?? $campaign->address_city,
            'fulfillment_shipping_state'    => $campaign->fulfillment_shipping_state ?? $campaign->address_state,
            'fulfillment_shipping_zip_code' => $campaign->fulfillment_shipping_zip_code ?? $campaign->address_zip_code,
            'rush'                          => $campaign->rush ? 'yes' : 'no',
            'flexible'                      => $campaign->flexible,
            'due_at'                        => $defaultDueDate,
            'decorator_pocket'              => $campaign->decorator_pocket,
            'speciality_inks'               => $campaign->artwork_request->speciality_inks,
            'embellishment_names'           => $campaign->artwork_request->embellishment_names,
            'embellishment_numbers'         => $campaign->artwork_request->embellishment_numbers,
            'garment_arrival_date'          => Carbon::parse('+8 weekdays')->format('m/d/Y'),
            'printing_date'                 => Carbon::parse('+9 weekdays')->format('m/d/Y'),
            'days_in_transit'               => 3,
            'decorator'                     => $decorator->id,
            'sizes'                         => json_encode([
                ['id' => 0, 'sizes' => $sizes, 'supplier' => 22, 'eta' => '', 'ship_from' => '', 'quantity' => 75, 'total' => 0],
            ]),
            'shipping_option'               => 'fedex_2_day',
        ]);
        
        // Assert
        $response->assertRedirect('/dashboard/pblock/send_printer/' . $campaign->id);
        $response = $this->get('/dashboard/pblock/send_printer/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Fulfillment Garment Issue marked as Solved');
        $campaign = $campaign->fresh();
        $this->assertEquals(true, $campaign->fulfillment_valid ? true : false);
    }
    
    /**
     * @test
     */
    public function can_see_update_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($support);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('UPDATE ORDER FORM');
        $response->assertSeeText('VIEW ORDER FORM');
        $response->assertSeeText('DOWNLOAD ORDER FORM');
        $response->assertSee('/dashboard/pblock/send_printer/' . $campaign->id);
        $response->assertSee('/dashboard/pblock/send_printer/' . $campaign->id . '/review');
        $response->assertSee('/dashboard/pblock/send_printer/' . $campaign->id . '/download');
    }
    
    /**
     * @test
     */
    public function can_see_review_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/send_printer/' . $campaign->id . '/review');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('ORDER FORM');
    }
    
    //TODO: Enable tests with PDF generation
    public function can_download()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign();
        $this->be($support);
        $response = $this->get('/campaign/' . $campaign->id . '/Support');
        
        // Execute
        $response = $this->get('/dashboard/pblock/send_printer/' . $campaign->id . '/download');
        
        // Assert
        $response->assertStatus(200);
    }
}
