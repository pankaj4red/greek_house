<?php

namespace App\Repositories\Models;

use App\Models\CampaignFile;
use App\Models\CampaignQuote;
use Illuminate\Support\Collection;

/**
 * @method CampaignFile make()
 * @method Collection|CampaignFile[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignFile|null find($id)
 * @method CampaignFile create(array $parameters = [])
 */
class CampaignQuoteRepository extends ModelRepository
{
    protected $modelClassName = CampaignQuote::class;

    public function findByCampaignIdAndProductId($campaignId, $productId)
    {
        return $this->model->newQuery()->where('campaign_id', $campaignId)->where('product_id', $productId)->first();
    }
}
