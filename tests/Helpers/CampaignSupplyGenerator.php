<?php

namespace Tests\Helpers;

use App\Models\Campaign;
use App\Models\CampaignSupply;
use App\Models\CampaignSupplyEntry;
use App\Models\Model;
use App\Models\OrderEntry;

class CampaignSupplyGenerator
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
        $this->campaign = $campaign;
    }
    
    /**
     * @param int   $campaignId
     * @param int   $productColorId
     * @param int   $garmentSizeId
     * @param array $entries
     * @return CampaignSupplyGenerator
     */
    public static function create($campaignId, $productColorId, $garmentSizeId, $entries = [])
    {
        Model::disableEvents();
        
        $totalQuantity = array_sum($entries);
        
        $product = product_color_repository()->find($productColorId)->product;
        
        $campaignSupply = factory(CampaignSupply::class)->create([
            'supplier_id'      => supplier_repository()->first()->id,
            'campaign_id'      => $campaignId,
            'product_color_id' => $productColorId,
            'color_id'         => $productColorId,
            'quantity'         => $campaignId,
            'total'            => $totalQuantity * $product->price,
        ]);
        
        foreach ($entries as $short => $quantity) {
            factory(CampaignSupplyEntry::class)->create([
                'campaign_supply_id' => $campaignSupply->id,
                'garment_size_id'    => garment_size_repository()->findByShort($short),
                'quantity'           => $quantity,
                'price'              => $product->price,
                'subtotal'           => $product->price * $quantity,
            ]);
        }
        
        Model::enableEvents();
        
        return new CampaignSupplyGenerator($campaignSupply);
    }
    
    /**
     * @param $order
     * @param $entries
     * @return Campaign
     */
    public static function attachEntries($order, $entries)
    {
        foreach ($entries as $entry) {
            $sizeModel = garment_size_repository()->findByShort($entry->size);
            
            factory(OrderEntry::class)->create([
                'order_id'         => $order->id,
                'product_color_id' => $entry->product_color_id,
                'garment_size_id'  => $sizeModel->id,
                'quantity'         => $entry->quantity,
                'price'            => $order->campaign->quote_final ?? $order->campaign->quote_high,
                'subtotal'         => $entry->quantity * ($order->campaign->quote_final ?? $order->campaign->quote_high),
            ]);
        }
        
        return $order;
    }
}
