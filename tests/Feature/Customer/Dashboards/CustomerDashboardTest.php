<?php

namespace Tests\Feature\Customer\Dashboards;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_customer_dashboard()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('customer')->user();
        $campaign1 = CampaignGenerator::create('delivered')->withOwner($user)->campaign();
        $campaign2 = CampaignGenerator::create('delivered')->withOwner($user)->campaign();
        $campaign3 = CampaignGenerator::create('delivered')->withOwner($user)->campaign();
        $campaign4 = CampaignGenerator::create('collecting_payment')->withOwner($user)->campaign();
        
        $this->be($user);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(0, (new Crawler($response->content()))->filter('.view_links_table a'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.table-filters'));
        $response->assertSeeText('Open Orders');
        $this->assertCount(1, (new Crawler($response->content()))->filter('#open_table tbody tr'));
        $response->assertSeeText('Closed Orders');
        $this->assertCount(3, (new Crawler($response->content()))->filter('#closed_table tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign4->name);
    }
}