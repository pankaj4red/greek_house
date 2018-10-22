<?php

namespace Tests\Feature\Home;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class QuoteGeneratorTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_customer_quote_generator()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $this->be(UserGenerator::create('designer')->user());
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Quick Quote');
        $response->assertSee('Choose Garment Type');
        $response->assertSee('Choose Product');
        $response->assertSee('F. Colors');
        $response->assertSee('B. Colors');
        $response->assertSee('Estimated Quantity');
        $response->assertSee('SUBMIT');
    }
    
    /**
     * @test
     */
    public function can_use_customer_quote_generator()
    {
        // Prepare
        (new \BasicSeeder())->run();
        (new \GarmentGenderSeeder())->run();
        (new \GarmentCategorySeeder())->run();
        (new \ProductSeeder())->run();
        
        // Execute & Assert
        $response = $this->json('get', '/garment-category/' . garment_gender_repository()->first()->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['categories']);
        $content = json_decode($response->getContent());
        
        // Execute & Assert
        $response = $this->json('get', '/garment-brand/' . garment_gender_repository()->first()->id . '/' . $content->categories[0]->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['products']);
        $content = json_decode($response->getContent());
        
        // Execute & Assert
        $response = $this->json('get', '/quick-quote/screen?pid=' . $content->products[0]->id . '&cf=4&cb=2&eqf=24&eqt=47');
        $response->assertStatus(200);
        $response->assertJsonStructure(['quote']);
    }
    
    /**
     * @test
     */
    public function can_see_manager_quote_generator()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $this->be(UserGenerator::create('support')->user());
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Finalize quote');
        $response->assertSee('Update Design Hours (H)');
        $response->assertSee('Estimated Quantity');
        $response->assertSee('Style Number (SKU)');
        $response->assertSee('Choose a Garment Type');
        $response->assertSee('Update Product Price (Units)');
        $response->assertSee('Front Colors');
        $response->assertSee('Back Colors');
        $response->assertSee('Left Sleeve Colors');
        $response->assertSee('Right Sleeve Colors');
        $response->assertSee('Black Shirt');
    }
    
    /**
     * @test
     */
    public function can_use_manager_quote_generator()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $this->be(UserGenerator::create('support')->user());
        
        // Execute
        $response = $this->json('get', '/quick-quote-manager/screen?pn=product&pp=4.29&cf=1&cb=1&cl=0&cr=0&bs=no&eqf=24&eqt=24&dh=3');
        
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure(['quote']);
    }
}