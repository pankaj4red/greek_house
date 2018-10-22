<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\OrderGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class AccountManagerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_manager_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Manager');
        $response->assertSee('/account-manager/accounts');
    }
    
    /**
     * @test
     */
    public function can_see_manager_dashboard()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = UserGenerator::create('customer')->withAccountManager($manager)->user();
        }
        $this->be($manager);
        
        // Execute
        $response = $this->get('/account-manager/accounts');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campus Manager - Accounts');
        foreach ($users as $user) {
            $response->assertSeeText($user->getFullName());
            $response->assertSeeText($user->chapter);
            $response->assertSeeText($user->phone);
            $response->assertSeeText($user->email);
            $response->assertSee('/account-manager/account/' . $user->id);
        }
    }
    
    /**
     * @test
     */
    public function can_see_account_details()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $designer = UserGenerator::create('designer')->user();
        $user = UserGenerator::create('customer')->withAccountManager($manager)->withAddresses(3)->user();
        $campaign = CampaignGenerator::create('delivered')->withOwner($user)->withDesigner($designer)->campaign();
        OrderGenerator::create('success', $campaign->id, [
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'S', 'quantity' => 2],
            (object)['product_color_id' => $campaign->product_colors->first()->id, 'size' => 'M', 'quantity' => 3],
        ])->withOwner($user)->order();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/account-manager/account/' . $user->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campus Manager - Account Details - ' . $user->getFullName());
        $response->assertSeeText($user->getFullName());
        $response->assertSeeText($user->username);
        $response->assertSeeText($user->first_name);
        $response->assertSeeText($user->last_name);
        $response->assertSeeText($user->email);
        $response->assertSeeText($user->phone);
        $response->assertSeeText($user->school);
        $response->assertSeeText($user->chapter);
        $response->assertSeeText($manager->getFullName());
        $response->assertDontSeeText('No addresses');
        $response->assertSeeText($campaign->name);
        $response->assertSeeText($campaign->artwork_request->designer->first_name);
    }
    
    /**
     * @test
     */
    public function can_see_share_page()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/account-manager/share');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Campus Manager - Share');
        $response->assertSee('/signup/customer/information/' . $manager->id);
        $response->assertSee('/work-with-us/campus/' . $manager->id);
    }
}