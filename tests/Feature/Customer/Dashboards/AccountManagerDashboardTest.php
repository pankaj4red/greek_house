<?php

namespace Tests\Feature\Customer\Dashboards;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class AccountManagerDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_account_manager_dashboard_open()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $user1 = UserGenerator::create()->withAccountManager($manager)->user();
        $user2 = UserGenerator::create()->withAccountManager($manager)->user();
        $campaign1 = CampaignGenerator::create('collecting_payment')->withOwner($user1)->campaign();
        $campaign2 = CampaignGenerator::create('collecting_payment')->withOwner($user2)->campaign();
        $campaign3 = CampaignGenerator::create('collecting_payment')->withOwner($manager)->campaign();
        $campaign4 = CampaignGenerator::create('delivered')->withOwner($manager)->campaign();
        $campaign5 = CampaignGenerator::create('delivered')->withOwner($user1)->campaign();
        $campaign6 = CampaignGenerator::create('cancelled')->withOwner($manager)->campaign();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(3, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $response->assertSeeText('Cancelled');
        $response->assertSee('/dashboard/cancelled');
        $this->assertCount(3, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
    }
    
    /**
     * @test
     */
    public function can_see_account_manager_dashboard_closed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $user1 = UserGenerator::create()->withAccountManager($manager)->user();
        $user2 = UserGenerator::create()->withAccountManager($manager)->user();
        $campaign1 = CampaignGenerator::create('collecting_payment')->withOwner($user1)->campaign();
        $campaign2 = CampaignGenerator::create('collecting_payment')->withOwner($user2)->campaign();
        $campaign3 = CampaignGenerator::create('collecting_payment')->withOwner($manager)->campaign();
        $campaign4 = CampaignGenerator::create('delivered')->withOwner($manager)->campaign();
        $campaign5 = CampaignGenerator::create('delivered')->withOwner($user1)->campaign();
        $campaign6 = CampaignGenerator::create('cancelled')->withOwner($manager)->campaign();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/dashboard/closed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(3, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $response->assertSeeText('Cancelled');
        $response->assertSee('/dashboard/cancelled');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign4->name);
        $response->assertSeeText($campaign5->name);
    }
    
    /**
     * @test
     */
    public function can_see_account_manager_dashboard_cancelled()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $manager = UserGenerator::create('account_manager')->user();
        $user1 = UserGenerator::create()->withAccountManager($manager)->user();
        $user2 = UserGenerator::create()->withAccountManager($manager)->user();
        $campaign1 = CampaignGenerator::create('collecting_payment')->withOwner($user1)->campaign();
        $campaign2 = CampaignGenerator::create('collecting_payment')->withOwner($user2)->campaign();
        $campaign3 = CampaignGenerator::create('collecting_payment')->withOwner($manager)->campaign();
        $campaign4 = CampaignGenerator::create('delivered')->withOwner($manager)->campaign();
        $campaign5 = CampaignGenerator::create('delivered')->withOwner($user1)->campaign();
        $campaign6 = CampaignGenerator::create('cancelled')->withOwner($manager)->campaign();
        $this->be($manager);
        
        // Execute
        $response = $this->get('/dashboard/cancelled');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(3, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $response->assertSeeText('Cancelled');
        $response->assertSee('/dashboard/cancelled');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign6->name);
    }
    
}