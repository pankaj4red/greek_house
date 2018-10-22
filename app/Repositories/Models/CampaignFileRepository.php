<?php

namespace App\Repositories\Models;

use App\Models\CampaignFile;
use Illuminate\Support\Collection;

/**
 * @method CampaignFile make()
 * @method Collection|CampaignFile[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignFile|null find($id)
 * @method CampaignFile create(array $parameters = [])
 */
class CampaignFileRepository extends ModelRepository
{
    protected $modelClassName = CampaignFile::class;

    public function findByCampaignIdAndFileId($campaignId, $campaignFileId)
    {
        return $this->model->newQuery()->where('id', $campaignFileId)->where('campaign_id', $campaignId)->first();
    }
}
