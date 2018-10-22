<?php

namespace App\Repositories\Models;

use App\Models\CampaignSupply;
use Illuminate\Support\Collection;

/**
 * @method CampaignSupply make()
 * @method Collection|CampaignSupply[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignSupply|null find($id)
 * @method CampaignSupply create(array $parameters = [])
 */
class CampaignSupplyRepository extends ModelRepository
{
    protected $modelClassName = CampaignSupply::class;
}
