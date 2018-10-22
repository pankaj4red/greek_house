<?php

namespace App\Repositories\Models;

use App\Models\CampaignLeadProduct;
use App\Models\CampaignLeadProductColor;
use Illuminate\Support\Collection;

/**
 * @method CampaignLeadProduct make()
 * @method Collection|CampaignLeadProduct[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignLeadProduct|null find($id)
 */
class CampaignLeadProductRepository extends ModelRepository
{
    protected $modelClassName = CampaignLeadProduct::class;

    protected $rules = [];

    /**
     * @param integer $campaignLeadId
     * @param integer $productId
     * @param integer $colorId
     * @return CampaignLeadProduct
     */
    public function createTree($campaignLeadId, $productId, $colorId)
    {
        $product = $this->model->newQuery()->create([
            'campaign_lead_id' => $campaignLeadId,
            'product_id'       => $productId,
        ]);

        if (is_array($colorId)) {
            $colorIdList = $colorId;
            foreach ($colorIdList as $colorId) {
                $this->addColorToTree($product, $colorId);
            }
        } else {
            $this->addColorToTree($product, $colorId);
        }

        return $product->fresh();
    }

    public function addColorToTree($campaignLeadProduct, $colorId)
    {
        $productColor = CampaignLeadProductColor::query()->create([
            'campaign_lead_product_id' => $campaignLeadProduct->id,
            'color_id'                 => $colorId,
        ]);
    }
}
