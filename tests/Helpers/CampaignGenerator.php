<?php

namespace Tests\Helpers;

use App\Models\ArtworkRequest;
use App\Models\ArtworkRequestFile;
use App\Models\Campaign;
use App\Models\DesignTag;
use App\Models\DesignTagGroup;
use App\Models\File;
use App\Models\Model;
use App\Models\User;
use Carbon\Carbon;

class  CampaignGenerator
{
    /**
     * @var Campaign $campaign
     */
    public $campaign;
    
    /**
     * @param Campaign $campaign
     */
    public function __construct($campaign)
    {
        $this->campaign = $campaign->fresh();
    }
    
    /**
     * @param null        $state
     * @param string|null $type
     * @return CampaignGenerator
     */
    public static function create($state = null, $type = null)
    {
        Model::disableEvents();
        $actualState = $state;
        if ($state == 'claimed') {
            $actualState = 'awaiting_design';
        }
        if ($state == 'invalid_artwork') {
            $actualState = 'fulfillment_validation';
        }
        if ($state == 'invalid_garment') {
            $actualState = 'fulfillment_validation';
        }
        if ($type) {
            $campaign = factory(Campaign::class)->states($type)->create([
                'state' => $actualState ?? 'awaiting_design',
            ]);
        } else {
            $campaign = factory(Campaign::class)->create([
                'state' => $actualState ?? 'awaiting_design',
            ]);
        }
        
        static::attachProducts($campaign);
        static::attachArtworkRequest($campaign);
        
        switch ($state) {
            case 'cancelled':
                /** @noinspection PhpMissingBreakStatementInspection */
            case 'delivered':
                $campaign->update([
                    'tracking_code'  => 'xn8989sns9',
                    'scheduled_date' => Carbon::parse('+6 weekdays'),
                    'invoice_total'  => 320.5,
                ]);
            case 'shipped':
                /** @noinspection PhpMissingBreakStatementInspection */
            case 'printing':
                $campaign->update([
                    'printing_date' => Carbon::parse('+6 weekdays'),
                ]);
            case 'fulfillment_validation':
            case 'invalid_garment':
                /** @noinspection PhpMissingBreakStatementInspection */
            case 'invalid_artwork':
                $campaign->update([
                    'days_in_transit'         => '3',
                    'assigned_decorator_date' => Carbon::parse('-2 weekdays'),
                    'garment_arrival_date'    => Carbon::parse('+3 weekdays'),
                    'printing_date'           => Carbon::parse('+4 weekdays'),
                ]);
                if ($state == 'invalid_garment') {
                    $campaign->update([
                        'fulfillment_valid'          => false,
                        'fulfillment_invalid_reason' => 'Garment',
                        'fulfillment_invalid_text'   => 'Garment is out of stock',
                    ]);
                }
                if ($state == 'invalid_artwork') {
                    $campaign->update([
                        'fulfillment_valid'          => false,
                        'fulfillment_invalid_reason' => 'Artwork',
                        'fulfillment_invalid_text'   => 'Artwork file type is invalid',
                    ]);
                }
                $campaign->update([
                    'fulfillment_shipping_name'     => 'Shipping Name',
                    'fulfillment_shipping_line1'    => 'Line 1',
                    'fulfillment_shipping_city'     => 'City',
                    'fulfillment_shipping_state'    => 'State',
                    'fulfillment_shipping_zip_code' => '10000',
                    'fulfillment_shipping_country'  => 'usa',
                ]);
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'fulfillment_ready':
                artwork_request_file_repository()->create([
                    'file_id'            => FileGenerator::create('image')->file()->id,
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'sort'               => 1,
                    'type'               => 'print_file',
                ]);
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'processing_payment':
                $campaign->update([
                    'quote_final' => '17.50',
                ]);
                static::attachOrders($campaign);
                if (in_array($state, ['cancelled', 'delivered', 'shipped', 'printing', 'fulfillment_validation', 'invalid_garment', 'invalid_artwork'])) {
                    static::attachSupply($campaign);
                }
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'collecting_payment':
                $campaign->update([
                    'quote_low'  => '17.50',
                    'quote_high' => '22.50',
                    'close_date' => Carbon::parse('+3 weekdays'),
                ]);
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'awaiting_quote':
                $campaign->artwork_request->update([
                    'design_minutes' => '90',
                ]);
            /** @noinspection PhpMissingBreakStatementInspection */
            case 'revision_requested':
                $campaign->artwork_request->update([
                    'revision_text'  => 'Revision text',
                    'revision_count' => 0,
                ]);
            case 'awaiting_approval':
                artwork_request_file_repository()->create([
                    'file_id'            => FileGenerator::create('image')->file()->id,
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'sort'               => 1,
                    'type'               => 'proof_front',
                    'product_color_id'   => $campaign->product_colors->first()->id,
                ]);
                artwork_request_file_repository()->create([
                    'file_id'            => FileGenerator::create('image')->file()->id,
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'sort'               => 2,
                    'type'               => 'proof_back',
                    'product_color_id'   => $campaign->product_colors->first()->id,
                ]);
                artwork_request_file_repository()->create([
                    'file_id'            => FileGenerator::create('image')->file()->id,
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'sort'               => 3,
                    'type'               => 'proof_close_up',
                    'product_color_id'   => $campaign->product_colors->first()->id,
                ]);
                artwork_request_file_repository()->create([
                    'file_id'            => FileGenerator::create('image')->file()->id,
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'sort'               => 3,
                    'type'               => 'proof_other',
                    'product_color_id'   => $campaign->product_colors->first()->id,
                ]);
                artwork_request_file_repository()->create([
                    'file_id'            => FileGenerator::create('image')->file()->id,
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'sort'               => 3,
                    'type'               => 'proof',
                    'product_color_id'   => null,
                ]);
                break;
            case 'claimed':
                $campaign->artwork_request->update([
                    'designer_id' => UserGenerator::create('designer')->user()->id,
                ]);
                break;
        }
        
        Model::enableEvents();
        design_repository()->createFromCampaign($campaign);
        
        return new CampaignGenerator($campaign);
    }
    
    /**
     * @param Campaign $campaign
     * @param int|null $count
     * @return Campaign
     */
    public static function attachProducts($campaign, $count = null)
    {
        $productColorCount = product_color_repository()->count();
        if ($count == null) {
            $count = rand(1, $productColorCount >= 4 ? 4 : $productColorCount - 1);
        }
        
        $productColorIdList = [];
        $productColorIndexes = array_random_indexes($productColorCount, $count);
        foreach ($productColorIndexes as $productColorIndex) {
            $productColor = product_color_repository()->findInPosition($productColorIndex);
            $productColorIdList = $productColor->id;
        }
        $campaign->product_colors()->sync($productColorIdList);
        
        return $campaign;
    }
    
    /**
     * @param Campaign $campaign
     * @return Campaign
     */
    public static function attachArtworkRequest($campaign)
    {
        $campaign->update([
            'artwork_request_id' => factory(ArtworkRequest::class)->create()->id,
        ]);
        
        return $campaign;
    }
    
    /**
     * @param Campaign $campaign
     * @return Campaign
     */
    public static function attachOrders($campaign)
    {
        $sizes = ['S', 'M', 'L'];
        $orderCount = rand(1, 3);
        $quantity = rand(144, 200);
        for ($orderIndex = 0; $orderIndex < $orderCount; $orderIndex++) {
            $orderQuantity = $quantity / $orderCount;
            $coloIndex = rand(0, $campaign->product_colors->count() - 1);
            $entryCount = rand(1, 10);
            $entries = [];
            for ($entryIndex = 0; $entryIndex < $entryCount; $entryIndex++) {
                $sizeIndex = rand(0, count($sizes) - 1);
                $entries[] = (object)[
                    'quantity'         => ceil($orderQuantity / $entryCount),
                    'product_color_id' => $campaign->product_colors[$coloIndex]->id,
                    'size'             => $sizes[$sizeIndex],
                ];
            }
            
            OrderGenerator::create('success', $campaign->id, $entries);
        }
        
        return $campaign;
    }
    
    /**
     * @param Campaign $campaign
     * @return Campaign
     */
    public static function attachSupply($campaign)
    {
        $sizes = [];
        $supplies = [];
        
        foreach ($campaign->orders as $order) {
            foreach ($order->entries as $entry) {
                if (! isset($supplies[$entry->product_color_id])) {
                    $supplies[$entry->product_color_id] = (object)[
                        'product_color_id' => $entry->product_color_id,
                        'garment_size_id'  => $entry->garment_size_id,
                        'sizes'            => [],
                    ];
                }
                if (! isset($supplies[$entry->product_color_id]->sizes[$entry->size->short])) {
                    $supplies[$entry->product_color_id]->sizes[$entry->size->short] = 0;
                }
                $supplies[$entry->product_color_id]->sizes[$entry->size->short] += $entry->quantity;
                $sizes[$entry->garment_size_id] = $entry->size->short;
            }
        }
        
        $sizes = sort_sizes($sizes);
        
        foreach ($supplies as $entry) {
            CampaignSupplyGenerator::create($campaign->id, $entry->product_color_id, $entry->garment_size_id, $entry->sizes);
        }
        
        return $campaign;
    }
    
    /**
     * @param User|null $user
     * @return $this
     */
    public function withOwner($user = null)
    {
        $this->campaign->update([
            'user_id' => $user ? $user->id : null,
        ]);
        
        return $this;
    }
    
    /**
     * @param User|null $user
     * @return $this
     */
    public function withDesigner($user = null)
    {
        $this->campaign->artwork_request->update([
            'designer_id' => $user ? $user->id : null,
        ]);
        
        return $this;
    }
    
    /**
     * @param User|null $user
     * @return $this
     */
    public function withDecorator($user = null)
    {
        $this->campaign->update([
            'decorator_id' => $user ? $user->id : null,
        ]);
        
        return $this;
    }
    
    /**
     * @param null $override
     * @return Campaign $campaign
     */
    public function campaign($override = null)
    {
        if ($override) {
            $this->campaign->update($override);
            $this->campaign = $this->campaign->fresh();
        }
        
        return $this->campaign;
    }
    
    public function withExpensiveProduct()
    {
        $product = product_repository()->getExpensive();
        $color = $product->colors->first();
        
        $this->campaign->product_colors()->sync([$color->id]);
        
        return $this;
    }
    
    public function withSourceDesign()
    {
        $design = DesignGenerator::create()->design();
        
        $this->campaign->update([
            'source_design_id' => $design->id,
        ]);
        
        return $this;
    }
    
    public function withProof()
    {
        factory(ArtworkRequestFile::class)->create([
            'artwork_request_id' => $this->campaign->artwork_request_id,
            'file_id'            => factory(File::class)->create(),
        ]);
        
        return $this;
    }
    
    public function withDesign($withTags = false)
    {
        $design = DesignGenerator::create('fake', 1, ['campaign_id' => $this->campaign->id])->design();
        
        if ($withTags) {
            foreach (DesignTagGroup::all() as $group) {
                for ($i = 0; $i < rand(1, 4); $i++) {
                    Factory(DesignTag::class)->create([
                        'design_id' => $design->id,
                        'group'     => $group->code,
                    ]);
                }
            }
        }
        
        return $this;
    }
}
