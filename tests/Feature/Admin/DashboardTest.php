<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function support_can_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Admin');
        $response->assertSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function admin_can_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('admin')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Admin');
        $response->assertSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function product_qa_can_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('product_qa')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Admin');
        $response->assertSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function product_manager_can_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('product_manager')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Admin');
        $response->assertSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function customer_can_not_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('customer')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Admin');
        $response->assertDontSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function sales_rep_can_not_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('sales_rep')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Admin');
        $response->assertDontSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function manager_can_not_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('account_manager')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Admin');
        $response->assertDontSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function designer_can_not_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('designer')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Admin');
        $response->assertDontSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function decorator_can_not_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('decorator')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Admin');
        $response->assertDontSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function art_director_can_not_see_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('art_director')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertDontSee('Admin');
        $response->assertDontSee('/admin/dashboard');
    }
    
    /**
     * @test
     */
    public function support_can_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('support')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function admin_can_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('admin')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function product_qa_can_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('product_qa')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function product_manager_can_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('product_manager')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function customer_can_not_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('customer')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(403);
    }
    
    /**
     * @test
     */
    public function sales_rep_can_not_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('sales_rep')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(403);
    }
    
    /**
     * @test
     */
    public function manager_can_not_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('account_manager')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(403);
    }
    
    /**
     * @test
     */
    public function designer_can_not_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('designer')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(403);
    }
    
    /**
     * @test
     */
    public function decorator_can_not_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('decorator')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(403);
    }
    
    /**
     * @test
     */
    public function art_director_can_not_access()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $support = UserGenerator::create('art_director')->user();
        $this->be($support);
        
        // Execute
        $response = $this->get('/admin/dashboard');
        
        // Assert
        $response->assertStatus(403);
    }
}