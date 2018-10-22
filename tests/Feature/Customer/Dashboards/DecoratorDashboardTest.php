<?php

namespace Tests\Feature\Customer\Dashboards;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class DecoratorDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_decorator_dashboard_today()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::now()->format('Y-m-d H:i:s')]);
        $campaign2 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'garment_arrival_date'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign3 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'printing_date'           => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign4 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign5 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign6 = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign7 = CampaignGenerator::create('delivered')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/dashboard');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(5, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.dashboard-filters'));
        $response->assertSeeText('Today');
        $response->assertSee('/dashboard/today');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Artwork &amp; Garments');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('#default-table tbody tr'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('#decorator-awaiting-garments tbody tr'));
        $this->assertCount(1, (new Crawler($response->content()))->filter('#decorator-printing tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
    }
    
    /**
     * @test
     */
    public function can_see_decorator_dashboard_open()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::now()->format('Y-m-d H:i:s')]);
        $campaign2 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'garment_arrival_date'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign3 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'printing_date'           => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign4 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign5 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign6 = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign7 = CampaignGenerator::create('delivered')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/dashboard/open');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(5, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.table-filters'));
        $response->assertSeeText('Today');
        $response->assertSee('/dashboard/today');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Artwork &amp; Garments');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(6, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign4->name);
        $response->assertSeeText($campaign5->name);
        $response->assertSeeText($campaign6->name);
    }
    
    /**
     * @test
     */
    public function can_see_decorator_dashboard_fulfillment_validation()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::now()->format('Y-m-d H:i:s')]);
        $campaign2 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'garment_arrival_date'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign3 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'printing_date'           => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign4 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign5 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign6 = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign7 = CampaignGenerator::create('delivered')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/dashboard/fulfillment_validation');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(5, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.table-filters'));
        $response->assertSeeText('Today');
        $response->assertSee('/dashboard/today');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Artwork &amp; Garments');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(5, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign1->name);
        $response->assertSeeText($campaign2->name);
        $response->assertSeeText($campaign3->name);
        $response->assertSeeText($campaign4->name);
        $response->assertSeeText($campaign5->name);
    }
    
    /**
     * @test
     */
    public function can_see_decorator_dashboard_printing()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::now()->format('Y-m-d H:i:s')]);
        $campaign2 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'garment_arrival_date'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign3 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'printing_date'           => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign4 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign5 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign6 = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign7 = CampaignGenerator::create('delivered')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/dashboard/printing');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(5, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.table-filters'));
        $response->assertSeeText('Today');
        $response->assertSee('/dashboard/today');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Artwork &amp; Garments');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(1, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign6->name);
    }
    
    /**
     * @test
     */
    public function can_see_decorator_dashboard_closed()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \SupplierSeeder())->run();
        (new \GarmentSizeSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        $decorator = UserGenerator::create('decorator')->user();
        $user = UserGenerator::create()->user();
        $campaign1 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::now()->format('Y-m-d H:i:s')]);
        $campaign2 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'garment_arrival_date'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign3 = CampaignGenerator::create('fulfillment_validation')->withOwner($user)->withDecorator($decorator)->campaign([
            'assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s'),
            'printing_date'           => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $campaign4 = CampaignGenerator::create('invalid_artwork')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign5 = CampaignGenerator::create('invalid_garment')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign6 = CampaignGenerator::create('printing')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign7 = CampaignGenerator::create('delivered')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $campaign8 = CampaignGenerator::create('cancelled')->withOwner($user)->withDecorator($decorator)->campaign(['assigned_decorator_date' => Carbon::parse('-10 days')->format('Y-m-d H:i:s')]);
        $this->be($decorator);
        
        // Execute
        $response = $this->get('/dashboard/closed');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(5, (new Crawler($response->content()))->filter('.nav-tabs .nav-link'));
        $this->assertCount(0, (new Crawler($response->content()))->filter('.table-filters'));
        $response->assertSeeText('Today');
        $response->assertSee('/dashboard/today');
        $response->assertSeeText('Open');
        $response->assertSee('/dashboard/open');
        $response->assertSeeText('Artwork &amp; Garments');
        $response->assertSee('/dashboard/fulfillment_validation');
        $response->assertSeeText('Printing');
        $response->assertSee('/dashboard/printing');
        $response->assertSeeText('Closed');
        $response->assertSee('/dashboard/closed');
        $this->assertCount(2, (new Crawler($response->content()))->filter('.dashboard-table tbody tr'));
        $response->assertSeeText($campaign7->name);
        $response->assertSeeText($campaign8->name);
    }
}