<?php

namespace App\Repositories\Models;

use App\Models\CampaignSupplyEntry;
use Illuminate\Support\Collection;

/**
 * @method CampaignSupplyEntry make()
 * @method Collection|CampaignSupplyEntry[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignSupplyEntry|null find($id)
 * @method CampaignSupplyEntry create(array $parameters = [])
 */
class CampaignSupplyEntryRepository extends ModelRepository
{
    protected $modelClassName = CampaignSupplyEntry::class;
}
