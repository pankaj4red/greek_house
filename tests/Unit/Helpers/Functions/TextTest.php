<?php

namespace Tests\Feature\Admin;

use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class TextTest extends TestCase
{
    /**
     * @test
     */
    public function escape_entities_escapes_entities()
    {
        // Prepare
        $text = 'NIKECOURT PURE WOMEN\'S 17&quot; TENNIS SKIRT - Carmine';
        
        // Execute
        $result = escape_entities($text);
        
        // Assert
        $this->assertEquals('NIKECOURT PURE WOMEN&#039;S 17&quot; TENNIS SKIRT - Carmine', $result);
    }
    
    /**
     * @test
     */
    public function escape_entities_does_not_double_escape()
    {
        // Prepare
        $text = 'Sport-Tek&reg; 1/4-Zip Sweatshirt - White';
        
        // Execute
        $result = escape_entities($text);
        
        // Assert
        $this->assertEquals('Sport-Tek&reg; 1/4-Zip Sweatshirt - White', $result);
    }
}