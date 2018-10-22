<?php

namespace Tests\Feature\Admin;

use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ArrayTest extends TestCase
{
    /**
     * @test
     */
    public function array_equal_with_different_array_sizes()
    {
        // Prepare
        $array1 = ['a', 'b'];
        $array2 = ['a', 'b', 'c'];
        
        // Execute
        $result = array_equal($array1, $array2);
        
        // Assert
        $this->assertFalse($result);
    }
    
    /**
     * @test
     */
    public function array_equal_with_different_arrays()
    {
        // Prepare
        $array1 = ['a', 'b'];
        $array2 = ['a', 'c'];
        
        // Execute
        $result = array_equal($array1, $array2);
        
        // Assert
        $this->assertFalse($result);
    }
    
    /**
     * @test
     */
    public function array_equal_with_equal_arrays()
    {
        // Prepare
        $array1 = ['a', 'b'];
        $array2 = ['a', 'b'];
        
        // Execute
        $result = array_equal($array1, $array2);
        
        // Assert
        $this->assertTrue($result);
    }
    
    /**
     * @test
     */
    public function sort_sizes_with_invalid_sizes()
    {
        // Prepare
        $array = ['a', 'b'];
        
        // Execute
        $result = sort_sizes($array);
        
        // Assert
        $this->assertTrue(array_equal($result, ['a', 'b']));
    }
    
    /**
     * @test
     */
    public function sort_sizes_with_one_invalid_size()
    {
        // Prepare
        $array = ['a', 'M'];
        
        // Execute
        $result = sort_sizes($array);
        
        // Assert
        $this->assertTrue(array_equal($result, ['M', 'a']));
    }
    
    /**
     * @test
     */
    public function sort_sizes_with_valid_sizes()
    {
        // Prepare
        $array = ['M', 'L', 'S'];
        
        // Execute
        $result = sort_sizes($array);
        
        // Assert
        $this->assertTrue(array_equal($result, ['S', 'M', 'L']));
    }
    
    
}