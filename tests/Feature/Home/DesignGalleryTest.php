<?php

namespace Tests\Feature\Home;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\DesignGenerator;
use Tests\TestCase;

class DesignGalleryTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_design_gallery()
    {
        // Execute
        $response = $this->get('/design-gallery');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Design Gallery');
    }
    
    /**
     * @test
     */
    public function design_gallery_has_designs()
    {
        // Prepare
        DesignGenerator::create('fake', 50);
        
        // Execute
        $response = $this->get('/design-gallery');
        
        // Assert
        $response->assertStatus(200);
        $this->assertCount(48, (new Crawler($response->content()))->filter('.design-entry'));
    }
    
    /**
     * @test
     */
    public function can_paginate_design_gallery()
    {
        // Prepare
        DesignGenerator::create('fake', 50);
        
        // Execute
        $response = $this->get('/ajax/design-gallery/recent?page=2');
        
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'thumbnail_id']]]);
    }
    
    /**
     * @test
     */
    public function can_search_design_gallery()
    {
        // Prepare
        DesignGenerator::create('fake', 1, ['name' => 'ABC'], ['general' => ['foo1', 'bar1']]);
        DesignGenerator::create('fake', 1, ['name' => 'BCD'], ['general' => ['foo1', 'bar2']]);
        DesignGenerator::create('fake', 1, ['name' => 'CDE'], ['general' => ['foo2', 'bar2']]);
        DesignGenerator::create('fake', 1, ['name' => 'DEF'], ['general' => ['foo2', 'bar3']]);
        DesignGenerator::create('fake', 1, ['name' => 'EFG'], ['general' => ['foo3', 'bar3']]);
        
        // Execute
        $response = $this->get('/ajax/design-gallery/recent?tags=' . urlencode(implode(',', ['foo1', 'bar2'])));
        
        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'thumbnail_id', 'info']]]);
        $data = json_decode($response->content());
        $this->assertCount(3, $data->data);
        $this->assertEquals('BCD', $data->data[0]->name);
    }
}