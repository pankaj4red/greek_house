<?php

namespace Tests\Feature\Customer\Blocks;

use App\Models\ArtworkRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class UploadProofsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_block()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Designer');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Upload Proofs');
        $response->assertSee('/dashboard/pblock/upload_proofs/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_see_popup_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        
        // Execute
        $response = $this->get('/campaign/' . $campaign->id . '/Designer');
        
        // Assert
        $response->assertSee('/dashboard/pblock/upload_proofs/' . $campaign->id);
    }
    
    /**
     * @test
     */
    public function can_open_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        $response = $this->get('/campaign/' . $campaign->id . '/Designer');
        
        // Execute
        $response = $this->get('/dashboard/pblock/upload_proofs/' . $campaign->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('UPLOAD PROOFS');
    }
    
    /**
     * @test
     */
    public function can_submit_popup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $designer = UserGenerator::create('designer')->user();
        $campaign = CampaignGenerator::create()->withOwner($user)->withDesigner($designer)->campaign();
        $this->be($designer);
        $response = $this->get('/campaign/' . $campaign->id . '/Designer/');
        
        // Execute
        $response = $this->post('/dashboard/pblock/upload_proofs/' . $campaign->id, array_merge([
            'designer_colors_front'        => '4',
            'designer_colors_back'         => '5',
            'designer_colors_sleeve_left'  => '1',
            'designer_colors_sleeve_right' => '1',
            'designer_black_shirt'         => 'yes',
            'design_hours'                 => '1:35',
            'design_type'                  => 'screen',
            'speciality_inks'              => 'yes',
            'embellishment_names'          => 'yes',
            'embellishment_numbers'        => 'yes',
        ], $this->attachFile('proof1'), $this->attachFile('proof2'), $this->attachFile('proof3')));
        
        // Assert
        $response->assertRedirect('/campaign/' . $campaign->id . '/Designer/');
        $response = $this->get('/campaign/' . $campaign->id . '/Designer/');
        $response->assertStatus(200);
        $response->assertSee('Proof Information Saved');
        /** @var ArtworkRequest $artworkRequest */
        $this->assertDatabaseHas('artwork_requests', [
            'id'                           => $campaign->artwork_request_id,
            'designer_colors_front'        => 4,
            'designer_colors_back'         => 5,
            'designer_colors_sleeve_left'  => 1,
            'designer_colors_sleeve_right' => 1,
            'designer_black_shirt'         => true,
            'design_minutes'               => to_minutes('1:35'),
            'design_type'                  => 'screen',
            'speciality_inks'              => 'yes',
            'embellishment_names'          => 'yes',
            'embellishment_numbers'        => 'yes',
        ]);
    }
}
