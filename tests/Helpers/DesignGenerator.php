<?php

namespace Tests\Helpers;

use App\Models\Campaign;
use App\Models\Design;
use App\Models\DesignFile;
use App\Models\DesignTag;
use App\Models\DesignTagGroup;
use App\Models\File;

class DesignGenerator
{
    /**
     * @var Design $design
     */
    public $design;
    
    /**
     * @param Design $design
     */
    public function __construct($design)
    {
        $this->design = $design;
    }
    
    /**
     * @param string|null $type
     * @param int         $quantity
     * @param array       $override
     * @param array       $tags
     * @return Design[]|DesignGenerator
     */
    public static function create($type = null, $quantity = 1, $override = [], $tags = null)
    {
        if ($quantity == 1) {
            return static::innerCreate($type, $override, $tags);
        }
        
        $list = [];
        for ($i = 0; $i < $quantity; $i++) {
            $list[] =
                static::innerCreate($type, $override, $tags)
                      ->design();
        }
        
        return $list;
    }
    
    public static function createFromCampaign($campaign = null)
    {
        if (! $campaign) {
            $campaign =
                CampaignGenerator::create('delivered')
                                 ->campaign();
        }
        
        return static::innerCreateFromCampaign($campaign);
    }
    
    public static function innerCreate($type, $override, $tags = null)
    {
        if ($type) {
            $design =
                factory(Design::class)
                    ->states($type)
                    ->create(array_merge($override, ['status' => 'enabled']));
        } else {
            $design = factory(Design::class)->create($override);
        }
        
        static::attachImages($design);
        static::attachThumbnail($design);
        static::attachTags($design, $tags);
        
        return new DesignGenerator($design);
    }
    
    public static function innerCreateFromCampaign(Campaign $campaign)
    {
        $design = design_repository()->createFromCampaign($campaign);
        $design->update(['status' => 'enabled']);
        
        return new DesignGenerator($design);
    }
    
    public static function attachImages(Design $design)
    {
        factory(DesignFile::class)->create(
            [
                'design_id' => $design->id,
            ]
        );
    }
    
    public static function attachThumbnail(Design $design)
    {
        $design->update(
            [
                'thumbnail_id' => factory(File::class)
                    ->states('image')
                    ->create()->id,
            ]
        );
    }
    
    public static function attachTags(Design $design, $tags = [])
    {
        if (! $tags) {
            $groups = DesignTagGroup::all();
            foreach ($groups as $group) {
                $tagCount = rand(1, 3);
                for ($i = 0; $i < $tagCount; $i++) {
                    factory(DesignTag::class)->create(
                        [
                            'design_id' => $design->id,
                            'group'     => $group,
                        ]
                    );
                }
            }
        } else {
            foreach ($tags as $key => $groupTags) {
                foreach ($groupTags as $tag) {
                    factory(DesignTag::class)->create(
                        [
                            'design_id' => $design->id,
                            'name'      => $tag,
                            'group'     => $key,
                        ]
                    );
                }
            }
        }
    }
    
    /**
     * @return Design $design
     */
    public function design()
    {
        return $this->design;
    }
    
    public function withImages()
    {
        static::attachImages($this->design);
        static::attachThumbnail($this->design);
        
        return $this;
    }
}