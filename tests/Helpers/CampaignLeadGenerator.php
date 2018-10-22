<?php

namespace Tests\Helpers;

use App\Models\CampaignLead;
use App\Models\Model;

class CampaignLeadGenerator
{
    /**
     * @var CampaignLead $campaignLead
     */
    public $campaignLead;
    
    /**
     * @param CampaignLead $campaignLead
     */
    public function __construct($campaignLead)
    {
        $this->campaignLead = $campaignLead->fresh();
    }
    
    /**
     * @param null $state
     * @return CampaignLeadGenerator
     */
    public static function create($state = null)
    {
        Model::disableEvents();
        $campaignLead = factory(CampaignLead::class)->states($state)->create();
        static::attachProduct($campaignLead);
        Model::enableEvents();
        
        return new CampaignLeadGenerator($campaignLead);
    }
    
    /**
     * @param CampaignLead $campaignLead
     * @return CampaignLead
     */
    public static function attachProduct($campaignLead)
    {
        $productCount = product_repository()->getInexpensive()->count();
        $product = product_repository()->getInexpensive()->first();
        $productColorCount = product_color_repository()->getByProductId($product->id)->count();
        $productColor = product_color_repository()->getByProductId($product->id)->first();
        $campaignLead->update([
            'product_id' => $product->id,
            'color_id'   => $productColor->id,
        ]);
        
        return $campaignLead;
    }
    
    /**
     * @param null $override
     * @return CampaignLead $campaignLead
     */
    public function campaignLead($override = null)
    {
        if ($override) {
            $this->campaignLead->update($override);
            $this->campaignLead = $this->campaignLead->fresh();
        }
        
        return $this->campaignLead;
    }
    
    public function withExpensiveProduct()
    {
        $product = product_repository()->getExpensive()->first();
        $color = $product->colors->first();
        
        $this->campaignLead->update([
            'product_id' => $product->id,
            'color_id'   => $color->id,
        ]);
        
        return $this;
    }
}
