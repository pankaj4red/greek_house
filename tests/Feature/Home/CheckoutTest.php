<?php

namespace Tests\Feature\Home;

use App\Models\ProductSize;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\OrderGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_checkout_details()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $sizes = ProductSize::with('size')->where('product_id', $campaign->product_colors->first()->product_id)->get();
        
        // Execute
        $response = $this->get(route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]));
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee($campaign->name);
        $response->assertSee('Buy Now');
        foreach ($sizes as $size) {
            $response->assertSee($size->size->name);
        }
    }
    
    /**
     * @test
     */
    public function can_submit_checkout_details()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $sizes = ProductSize::with('size')->where('product_id', $campaign->product_colors->first()->product_id)->get();
        
        // Execute
        $sizeId = 0;
        foreach ($sizes as $size) {
            if ($size->size->short == 'M') {
                $sizeId = $size->id;
            }
        }
        $response = $this->post(route('custom_store::details', [product_to_description($campaign->id, $campaign->name)]), [
            'quantity' => [20],
            'size'     => [$sizeId],
        ]);
        
        // Assert
        $order = order_repository()->first();
        $response->assertRedirect(route('checkout::checkout', [product_to_description($campaign->id, $campaign->name), $order->id]));
    }
    
    /**
     * @test
     */
    public function can_see_checkout_page()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $order = OrderGenerator::create('new', $campaign->id, [
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'M', 'quantity' => 30],
        ])->order();
        
        // Execute
        $response = $this->get(route('checkout::checkout', [product_to_description($campaign->id, $campaign->name), $order]));
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee(route('checkout::ajax_save_information', [$order->id]));
    }
    
    /**
     * @test
     */
    public function can_save_information()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $order = OrderGenerator::create('new', $campaign->id, [
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'M', 'quantity' => 30],
        ])->order();
        
        // Execute
        $response = $this->postJson(route('checkout::ajax_save_information', [$order->id]), [
            'shipping_type'        => 'group',
            'contact_first_name'   => 'John',
            'contact_last_name'    => 'Doe',
            'contact_email'        => 'email@greekhouse.org',
            'contact_phone'        => '(555) 555-5555',
            'billing_line1'        => 'Line 1',
            'billing_line2'        => 'Line 2',
            'billing_city'         => 'City',
            'billing_state'        => 'State',
            'billing_zip_code'     => '10000',
            'payment_method'       => 'card',
            'manual_payment_price' => 23.36,
        ]);
        
        // Assert
        $this->assertEquals('ok', $response->content());
        $response->assertStatus(200);
        $order = $order->fresh();
        $this->assertEquals('group', $order->shipping_type);
        $this->assertEquals('John', $order->contact_first_name);
        $this->assertEquals('Doe', $order->contact_last_name);
        $this->assertEquals('email@greekhouse.org', $order->contact_email);
        $this->assertEquals('(555) 555-5555', $order->contact_phone);
        $this->assertEquals('Line 1', $order->billing_line1);
        $this->assertEquals('Line 2', $order->billing_line2);
        $this->assertEquals('City', $order->billing_city);
        $this->assertEquals('State', $order->billing_state);
        $this->assertEquals('10000', $order->billing_zip_code);
    }
    
    /**
     * @test
     */
    public function can_submit_test_checkout_page()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $order = OrderGenerator::create('filled_test', $campaign->id, [
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'M', 'quantity' => 30],
        ])->order();
        $this->be($support);
        
        // Execute
        $response = $this->post(route('checkout::checkout_test', [product_to_description($campaign->id, $campaign->name), $order->id]));
        
        // Assert
        $response->assertRedirect(route('custom_store::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        $response = $this->get(route('custom_store::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        $response->assertStatus(200);
        $response->assertSee('Your Order #');
        $order = $order->fresh();
        $this->assertEquals('success', $order->state);
    }
    
    /**
     * @test
     */
    public function can_submit_manual_checkout_page()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $order = OrderGenerator::create('filled_manual', $campaign->id, [
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'M', 'quantity' => 30],
        ])->order();
        $this->be($support);
        
        // Execute
        $response = $this->post(route('checkout::checkout_manual', [product_to_description($campaign->id, $campaign->name), $order->id]), [
            'manual_payment_price' => 23.5,
        ]);
        
        // Assert
        $response->assertRedirect(route('custom_store::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        $response = $this->get(route('custom_store::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        $response->assertStatus(200);
        $response->assertSee('Your Order #');
        $order = $order->fresh();
        $this->assertEquals('success', $order->state);
    }
    
    /**
     * @test
     */
    public function checkout_changes_campaign_state()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create()->user();
        $support = UserGenerator::create('support')->user();
        $campaign = CampaignGenerator::create('collecting_payment')->withOwner($user)->withDesigner($designer)->campaign();
        $order = OrderGenerator::create('filled_manual', $campaign->id, [
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'S', 'quantity' => 200],
        ])->order();
        $this->be($support);
        
        // Execute
        $response = $this->post(route('checkout::checkout_manual', [product_to_description($campaign->id, $campaign->name), $order->id]), [
            'manual_payment_price' => 23.5,
        ]);
        
        // Assert
        $response->assertRedirect(route('custom_store::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        $response = $this->get(route('custom_store::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        $response->assertStatus(200);
        $response->assertSee('Your Order #');
        $order = $order->fresh();
        $this->assertEquals('success', $order->state);
        $this->assertEquals('processing_payment', $order->campaign->state);
    }
}