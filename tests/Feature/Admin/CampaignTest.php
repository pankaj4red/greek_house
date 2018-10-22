<?php

namespace Tests\Feature\Admin;

use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campaigns');
        $response->assertSee('/admin/campaign/list');
    }
    
    /**
     * @test
     */
    public function can_see_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $this->generateCampaignList();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/list');

        // Assert
        $response->assertStatus(200);
        $this->assertCount(20, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
    }
    
    /**
     * @test
     */
    public function can_click_campaign_on_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $campaign = CampaignGenerator::create('on_hold')->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/list');
        $response->assertSee('/admin/campaign/read/' . $campaign->id);
        
        // Execute
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_click_user_on_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('customer')->user();
        $campaign = CampaignGenerator::create('on_hold')->withOwner($user)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/list');
        $response->assertSee('/admin/user/read/' . $user->id);
        
        // Execute
        $response = $this->get('/admin/user/read/' . $user->id);
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_click_designer_on_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('customer')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('on_hold')->withOwner($user)->withDesigner($designer)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/list');
        $response->assertSee('/admin/campaign/read/' . $campaign->id);
        
        // Execute
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_filter_by_campaign_id_on_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $this->generateCampaignList();
        $user = UserGenerator::create('customer')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('on_hold')->withOwner($user)->withDesigner($designer)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/list');
        $this->assertCount(20, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
        
        //
        // Execute
        $response = $this->get('/admin/campaign/list?filter_campaign_id=' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(1, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
        $response->assertSeeText($campaign->name);
    }
    
    /**
     * @test
     */
    public function can_filter_by_campaign_name_on_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $this->generateCampaignList();
        $user = UserGenerator::create('customer')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('on_hold')->withOwner($user)->withDesigner($designer)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/list');
        $this->assertCount(20, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
        
        // Execute
        $response = $this->get('/admin/campaign/list?filter_campaign_name=' . urlencode($campaign->name));
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(1, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
        $response->assertSeeText($campaign->name);
    }
    
    /**
     * @test
     */
    public function can_filter_by_campaign_state_on_list()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $this->generateCampaignList();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/list');
        $this->assertCount(20, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
        
        // Execute
        $response = $this->get('/admin/campaign/list?filter_campaign_state=on_hold');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(2, (new Crawler($response->content()))->filter('#campaign-list tbody tr'));
    }
    
    public function can_filter_by_user_name_on_list()
    {
        //TODO: SQLite doesn't support some aggregate functions so this can't be tested with current implementation
    }
    
    /**
     * @test
     */
    public function can_read_campaign()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('printing')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText((string)$campaign->id);
        $response->assertSeeText($campaign->name);
        $response->assertSeeText(campaign_state_caption($campaign->state));
        $response->assertSeeText($campaign->close_date->format('m/d/Y'));
        $response->assertSeeText($campaign->flexible);
        $response->assertSeeText($campaign->estimated_quantity);
        $response->assertSeeText(escape_entities($campaign->user->getFullName()));
        $response->assertSeeText(escape_entities($campaign->decorator->getFullName()));
        $response->assertSeeText(escape_entities($campaign->artwork_request->designer->getFullName()));
        $response->assertSeeText(to_hours($campaign->artwork_request->design_minutes));
        $response->assertSee(route('system::image', [$campaign->artwork_request->proofs->first()->file_id]));
        $response->assertSeeText(escape_entities($campaign->contact_first_name));
        $response->assertSeeText(escape_entities($campaign->contact_last_name));
        $response->assertSeeText($campaign->contact_email);
        $response->assertSeeText($campaign->contact_phone);
        $response->assertSeeText($campaign->contact_school);
        $response->assertSeeText($campaign->contact_chapter);
        $response->assertSeeText(escape_entities($campaign->address_name));
        $response->assertSeeText($campaign->address_line1);
        if ($campaign->address_line2) {
            $response->assertSeeText($campaign->address_line2);
        }
        $response->assertSeeText($campaign->address_city);
        $response->assertSeeText($campaign->address_state);
        $response->assertSeeText($campaign->address_zip_code);
        $response->assertSeeText($campaign->address_country);
        $response->assertSeeText($campaign->shipping_group ? 'Enabled' : 'Disabled');
        $response->assertSeeText($campaign->shipping_individual ? 'Enabled' : 'Disabled');
        $response->assertSeeText('$' . $campaign->quote_final);
        $response->assertSeeText($campaign->artwork_request->print_front_colors);
        $response->assertSeeText($campaign->artwork_request->print_front_description);
        $response->assertSee('/admin/campaign/update-general/' . $campaign->id);
        $response->assertSee('/admin/campaign/update-actors/' . $campaign->id);
        $response->assertSee('/admin/campaign/update-artwork-request/' . $campaign->id);
        $response->assertSee('/admin/campaign/update-products/' . $campaign->id);
        $response->assertSee('/admin/campaign/update-contact/' . $campaign->id);
        $response->assertSee('/admin/campaign/update-shipping/' . $campaign->id);
        $response->assertSee('/admin/campaign/update-quote/' . $campaign->id);
        
        foreach ($campaign->product_colors as $productColors) {
            $response->assertSeeText(escape_entities($productColors->product->name . ' - ' . $productColors->name));
            $response->assertSee(route('system::image', [$productColors->image_id]));
        }
    }
    
    /**
     * @test
     */
    public function can_read_update_general()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-general/' . $campaign->id);
        
        // Assert
        $response->assertSee((string)$campaign->id);
        $response->assertSee($campaign->name);
        $response->assertSee($campaign->state);
        $response->assertSee($campaign->close_date->format('m/d/Y'));
    }
    
    /**
     * @test
     */
    public function can_submit_update_general()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/update-general/' . $campaign->id);
        
        // Execute
        $response = $this->post('/admin/campaign/update-general/' . $campaign->id, [
            'name'                 => 'Test Campaign',
            'state'                => 'printing',
            'close_date'           => Carbon::parse('-3 days')->format('m/d/Y'),
            'flexible'             => 'no',
            'date'                 => Carbon::parse('+3 days')->format('m/d/Y'),
            'scheduled_date'       => Carbon::parse('+2 days')->format('m/d/Y'),
            'promo_code'           => 'foo_code',
            'estimated_quantity'   => '72-143',
            'budget'               => 'yes',
            'budget_range'         => '$15-$18',
            'reminders'            => 'off',
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        $response->assertSeeText('Test Campaign');
        $response->assertSeeText('Printing');
        $response->assertSeeText(Carbon::parse('-3 days')->format('m/d/Y'));
        $response->assertSeeText(Carbon::parse('+3 days')->format('m/d/Y'));
        $response->assertSeeText(Carbon::parse('+2 days')->format('m/d/Y'));
        $response->assertSeeText('No');
        $response->assertSeeText('foo_code');
        $response->assertSeeText('72-143');
        $response->assertSeeText('Yes');
        $response->assertSeeText('$15-$18');
    }
    
    /**
     * @test
     */
    public function can_read_update_actors()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-actors/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee((string)$campaign->user_id);
        $response->assertSee((string)$campaign->artwork_request->designer_id);
        $response->assertSee((string)$campaign->decorator_id);
    }
    
    /**
     * @test
     */
    public function can_submit_update_actors()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $newUser = UserGenerator::create('customer')->user();
        $newDesigner = UserGenerator::create('designer')->user();
        $newDecorator = UserGenerator::create('decorator')->user();
        $this->be($support);
        
        // Execute
        $response = $this->post('/admin/campaign/update-actors/' . $campaign->id, [
            'user_id'      => $newUser->id,
            'designer_id'  => $newDesigner->id,
            'decorator_id' => $newDecorator->id,
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        $response->assertSeeText(escape_entities($newUser->getFullName()));
        $response->assertSeeText(escape_entities($newDesigner->getFullName()));
        $response->assertSeeText(escape_entities($newDecorator->getFullName()));
    }
    
    /**
     * @test
     */
    public function can_read_update_artwork_request()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-artwork-request/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('screen');
        $response->assertSee(print_type_caption($campaign->artwork_request->design_type));
        $response->assertSee(to_hours($campaign->artwork_request->design_minutes));
        $response->assertSee($campaign->artwork_request->revision_text);
        $response->assertSee($campaign->artwork_request->print_front_description);
        
    }
    
    /**
     * @test
     */
    public function can_submit_update_artwork_request()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->post('/admin/campaign/update-artwork-request/' . $campaign->id, array_merge([
            'design_type'              => 'embroidery',
            'design_hours'             => to_hours($campaign->artwork_request->design_minutes),
            'hourly_rate'              => 40.50,
            'revision_text'            => 'this is a revision text',
            'print_front'              => 'no',
            'print_front_colors'       => 3,
            'print_front_description'  => 'This is a print front description',
            'print_pocket'             => 'yes',
            'print_pocket_colors'      => 1,
            'print_pocket_description' => 'This is a print pocket description',
            'print_back'               => 'yes',
            'print_back_colors'        => 4,
            'print_back_description'   => 'This is a print back description',
            'print_sleeve'             => 'yes',
            'print_sleeve_preferred'   => 'right',
            'print_sleeve_colors'      => 1,
            'print_sleeve_description' => 'This is a print sleeve description',
        ], $this->attachFile('proof1')));
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        //TODO
    }
    
    /**
     * @test
     */
    public function can_read_update_products()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-products/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        foreach ($campaign->product_colors as $productColor) {
            $response->assertSee((string)$productColor->product_id);
            $response->assertSee((string)$productColor->id);
        }
    }
    
    /**
     * @test
     */
    public function can_submit_update_products()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $newProducts = [];
        $newColors = [];
        $names = [];
        for ($i = 0; $i < 3; $i++) {
            $randomProductColor = product_color_repository()->getRandom();
            $newColors[] = $randomProductColor->id;
            $newProducts[] = $randomProductColor->product_id;
            $names[] = $randomProductColor->product->name . ' - ' . $randomProductColor->name;
        }
        $this->be($support);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        
        // Execute
        $response = $this->post('/admin/campaign/update-products/' . $campaign->id, [
            'product_id' => $newProducts,
            'color_id'   => $newColors,
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        
        foreach ($names as $name) {
            $response->assertSeeText(escape_entities($name));
        }
    }
    
    /**
     * @test
     */
    public function can_get_product_colors()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/product-colors/' . $campaign->product_colors->first()->product_id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'colors']);
    }
    
    /**
     * @test
     */
    public function can_read_update_contact()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user([]);
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-contact/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee(escape_entities($campaign->contact_first_name));
        $response->assertSee(escape_entities($campaign->contact_last_name));
        $response->assertSee($campaign->contact_email);
        $response->assertSee($campaign->contact_phone);
        $response->assertSee(escape_entities($campaign->contact_school));
        $response->assertSee(escape_entities($campaign->contact_chapter));
    }
    
    /**
     * @test
     */
    public function can_submit_update_contact()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->post('/admin/campaign/update-contact/' . $campaign->id, [
            'contact_first_name' => 'John',
            'contact_last_name'  => 'Doe',
            'contact_email'      => 'email@greekhouse.org',
            'contact_phone'      => '(555) 666-7777',
            'contact_school'     => 'Another Generic School',
            'contact_chapter'    => 'Fee Fi Fo',
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        $response->assertSeeText('John');
        $response->assertSeeText('Doe');
        $response->assertSeeText('email@greekhouse.org');
        $response->assertSeeText('(555) 666-7777');
        $response->assertSeeText('Another Generic School');
        $response->assertSeeText('Fee Fi Fo');
    }
    
    /**
     * @test
     */
    public function can_read_update_shipping()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-shipping/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee(escape_entities($campaign->address_name));
        $response->assertSee($campaign->address_line1);
        $response->assertSee($campaign->address_line2);
        $response->assertSee($campaign->address_city);
        $response->assertSee($campaign->address_state);
        $response->assertSee($campaign->address_zip_code);
    }
    
    /**
     * @test
     */
    public function can_submit_update_shipping()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->post('/admin/campaign/update-shipping/' . $campaign->id, [
            'address_name'        => 'John Doe',
            'address_line1'       => 'AddressLine1',
            'address_line2'       => 'AddressLine2',
            'address_city'        => 'Los Angeles',
            'address_state'       => 'CA',
            'address_zip_code'    => '22112',
            'shipping_group'      => 'yes',
            'shipping_individual' => 'yes',
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        $response->assertSeeText('John Doe');
        $response->assertSeeText('AddressLine1');
        $response->assertSeeText('AddressLine2');
        $response->assertSeeText('Los Angeles');
        $response->assertSeeText('CA');
        $response->assertSeeText('22112');
        //TODO: find how to test these "Enabled" texts
    }
    
    /**
     * @test
     */
    public function can_read_update_quote()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/update-quote/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee($campaign->quote_low);
        $response->assertSee($campaign->quote_high);
        $response->assertSee($campaign->quote_final);
    }
    
    /**
     * @test
     */
    public function can_submit_update_quote_not_final()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->post('/admin/campaign/update-quote/' . $campaign->id, [
            'quote_low'   => 20.30,
            'quote_high'  => 30.50,
            'quote_final' => '',
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        $response->assertSeeText('[$' . number_format(20.30, 2) . ' - $' . number_format(30.50, 2) . ']');
    }
    
    /**
     * @test
     */
    public function can_submit_update_quote_final()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create('delivered')->withDesigner($designer)->withDesign()->withOwner($user)->withDecorator($decorator)->campaign();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        $response = $this->get('/admin/campaign/update-quote/' . $campaign->id);
        
        // Execute
        $response = $this->post('/admin/campaign/update-quote/' . $campaign->id, [
            'quote_low'   => 20.30,
            'quote_high'  => 30.50,
            'quote_final' => 25.60,
        ]);
        
        // Assert
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Order Information Saved');
        $response->assertSeeText('$' . number_format(25.60, 2));
    }
    
    /**
     * @test
     */
    public function can_read_create()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/campaign/create');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_submit_create()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $decorator = UserGenerator::create('decorator')->user();
        $designer = UserGenerator::create('designer')->user();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->post('/admin/campaign/create', [
            'name'               => 'Testing Campaign',
            'state'              => 'awaiting_design',
            'flexible'           => 'no',
            'date'               => Carbon::parse('+12 weekdays')->format('m/d/Y'),
            'design_type'        => 'embroidery',
            'estimated_quantity' => '48-71',
        ]);
        
        // Assert
        $campaign = campaign_repository()->last();
        $response->assertRedirect('/admin/campaign/read/' . $campaign->id);
        $response = $this->get('/admin/campaign/read/' . $campaign->id);
        $response->assertStatus(200);
        $response->assertSeeText('Testing Campaign');
        $response->assertSeeText('Awaiting Design');
        $response->assertSeeText('No');
        $response->assertSeeText(Carbon::parse('+12 weekdays')->format('m/d/Y'));
        $response->assertSeeText('Embroidery');
        $response->assertSeeText('48-71');
        $this->assertNotNull(Design::query()->where('campaign_id', $campaign->id)->first());
    }
    
    private function generateCampaignList()
    {
        for ($i = 0; $i < 2; $i++) {
            foreach ([
                         'on_hold',
                         'campus_approval',
                         'awaiting_design',
                         'awaiting_approval',
                         'revision_requested',
                         'awaiting_quote',
                         'collecting_payment',
                         'processing_payment',
                         'fulfillment_ready',
                         'fulfillment_validation',
                         'printing',
                         'shipped',
                         'delivered',
                         'cancelled',
                     ] as $state) {
                $user = UserGenerator::create('customer')->user();
                CampaignGenerator::create($state)->withOwner($user)->withDesigner();
            }
        }
    }
}