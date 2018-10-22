<?php

namespace Tests\Feature\Admin;

use App\Models\Design;
use App\Models\DesignTagGroup;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\DesignGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class DesignTest extends TestCase
{
    use DatabaseMigrations;
    
    //TODO: tests
//    /**
//     * @test
//     */
//    public function can_see_url()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/dashboard');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Campaigns');
//        $response->assertSee('/admin/design/list');
//    }
//
//    /**
//     * @test
//     */
//    public function can_see_list()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        DesignGenerator::create('fake', 50);
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/design/list');
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/list');
//        $this->assertCount(20, (new Crawler($response->content()))->filter('#design-list tbody tr'));
//    }
//
//    /**
//     * @test
//     */
//    public function can_click_design_on_list()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        DesignGenerator::create('fake', 10);
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//        $response = $this->get('/admin/design/list');
//
//        // Execute
//        $this->click($design->name);
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/read/' . $design->id);
//    }
//
//    /**
//     * @test
//     */
//    public function can_read()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->withImages()->design();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/design/read/' . $design->id);
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/read/' . $design->id);
//        $response->assertSee('/admin/design/delete/' . $design->id);
//        $response->assertSee('/admin/design/update-general/' . $design->id);
//        $response->assertSee('/admin/design/update-tags/' . $design->id);
//        $response->assertSee('/admin/design/update-images/' . $design->id);
//        $response->assertSeeText($design->name);
//        $response->assertSeeText($design->code);
//        $response->assertSeeText($design->campaign->name);
//        $response->assertSeeText(ucfirst($design->status));
//        $response->assertSeeText(route('system::image', [$design->thumbnail_id]));
//        foreach (DesignTagGroup::all() as $group) {
//            foreach ($design->getTags($group->code) as $tag) {
//                $response->assertSeeText($tag->name);
//            }
//        }
//        foreach ($design->files as $file) {
//            if ($file->type == 'image') {
//                $response->assertSeeText(route('system::image', [$file->file_id]));
//            }
//        }
//    }
//
//    /**
//     * @test
//     */
//    public function can_see_update_general()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $user = UserGenerator::create('customer')->user();
//        $designer = UserGenerator::create('designer')->user();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/design/update-general/' . $design->id);
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/update-general/' . $design->id);
//        $response->assertSeeText($design->name);
//        $response->assertSeeText($design->code);
//        $response->assertSeeText($design->campaign_id);
//        $this->seeIsSelected('status', $design->status);
//        $this->seeIsSelected('trending', $design->trending ? 'yes' : 'no');
//    }
//
//    /**
//     * @test
//     */
//    public function can_submit_update_general()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $user = UserGenerator::create('customer')->user();
//        $designer = UserGenerator::create('designer')->user();
//        $support = UserGenerator::create('support')->user();
//        $campaign = CampaignGenerator::create('printing')->withOwner($user)->withDesigner($designer)->campaign();
//        $oldThumbnailId = $design->thumbnail_id;
//        $this->be($support);
//        $response = $this->get('/admin/design/update-general/' . $design->id);
//
//        // Execute
//        $this->type('New Design Name', 'name');
//        $this->type('code123', 'code');
//        $this->select('enabled', 'status');
//        $this->select('yes', 'trending');
//        $this->attachFile('thumbnail');
//        $this->press('Save');
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/read/' . $design->id);
//        $response->assertSeeText('New Design Name');
//        $response->assertSeeText('code123');
//        $response->assertSeeText('Yes');
//        $response->assertSeeText('Enabled');
//        $response->assertSeeText($campaign->id);
//        $this->dontSee(route('system::image', [$oldThumbnailId]));
//        $design = $design->fresh();
//        $this->assertEquals('enabled', $design->status);
//
//    }
//
//    /**
//     * @test
//     */
//    public function can_see_update_tags()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $user = UserGenerator::create('customer')->user();
//        $designer = UserGenerator::create('designer')->user();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/design/update-general/' . $design->id);
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/update-general/' . $design->id);
//        $response->assertSeeText($design->name);
//        $response->assertSeeText($design->code);
//        $response->assertSeeText($design->campaign_id);
//    }
//
//    /**
//     * @test
//     */
//    public function can_submit_update_tags()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $support = UserGenerator::create('support')->user();
//        $oldTags = [];
//        foreach (design_tag_group_repository()->all() as $group) {
//            foreach ($design->getTags($group->code) as $tag) {
//                $oldTags[] = $tag->name;
//            }
//        }
//        $this->be($support);
//        $response = $this->get('/admin/design/update-tags/' . $design->id);
//        foreach ($oldTags as $tag) {
//            $response->assertSeeText($tag);
//        }
//
//        // Execute
//        $this->type('tag11,tag12,tag13', 'tag_general');
//        $this->type('tag1,tag2,tag 3', 'tag_themes');
//        $this->type('tag 4', 'tag_event');
//        $this->type('college tag', 'tag_college');
//        $this->type('chapter tag', 'tag_chapter');
//        $this->type('Product Type Tag,', 'tag_product_type');
//        $this->press('Save');
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/read/' . $design->id);
//        $response->assertSeeText('tag1');
//        $response->assertSeeText('tag2');
//        $response->assertSeeText('tag 3');
//        $response->assertSeeText('tag 4');
//        $response->assertSeeText('college tag');
//        $response->assertSeeText('chapter tag');
//        $response->assertSeeText('Product Type Tag');
//        $response->assertSeeText('tag11');
//        $response->assertSeeText('tag12');
//        $response->assertSeeText('tag13');
//        foreach ($oldTags as $tag) {
//            $this->dontSee($tag);
//        }
//    }
//
//    /**
//     * @test
//     */
//    public function can_see_update_images()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $user = UserGenerator::create('customer')->user();
//        $designer = UserGenerator::create('designer')->user();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/design/update-images/' . $design->id);
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/update-images/' . $design->id);
//        foreach ($design->files as $file) {
//            $response->assertSeeText(route('system::image', [$file->file_id]));
//        }
//    }
//
//    /**
//     * @test
//     */
//    public function can_submit_update_images()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $support = UserGenerator::create('support')->user();
//        $oldFiles = [];
//        foreach ($design->files as $file) {
//            $oldFiles[] = $file->file_id;
//        }
//        $this->be($support);
//        $response = $this->get('/admin/design/update-images/' . $design->id);
//        foreach ($design->files as $file) {
//            $response->assertSeeText(route('system::image', [$file->file_id]));
//        }
//
//        // Execute
//        $this->attachFile('image0');
//        $this->attachFile('image1');
//        $this->attachFile('image2');
//        $this->attachFile('image3');
//        $this->attachFile('image4');
//        $this->press('Save');
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/read/' . $design->id);
//        foreach ($oldFiles as $fileId) {
//            $this->dontSee(route('system::image', [$fileId]));
//        }
//        $design->load('files');
//        $this->assertCount(5, $design->files);
//    }
//
//    /**
//     * @test
//     */
//    public function can_see_delete()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//
//        // Execute
//        $response = $this->get('/admin/design/delete/' . $design->id);
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/delete/' . $design->id);
//    }
//
//    /**
//     * @test
//     */
//    public function can_submit_delete()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $design = DesignGenerator::createFromCampaign()->design();
//        $support = UserGenerator::create('support')->user();
//        $this->be($support);
//        $response = $this->get('/admin/design/delete/' . $design->id);
//
//        // Execute
//        $this->press('Delete');
//
//        // Assert
//        $response->assertStatus(200);
//        $this->seePageIs('/admin/design/list');
//        $response->assertSeeText('Design Deleted');
//        $this->assertNull(Design::query()->find($design->id));
//    }
}