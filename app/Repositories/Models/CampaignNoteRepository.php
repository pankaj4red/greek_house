<?php

namespace App\Repositories\Models;

use App\Models\CampaignNote;
use Illuminate\Support\Collection;

/**
 * @method CampaignNote make()
 * @method Collection|CampaignNote[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignNote|null find($id)
 * @method CampaignNote create(array $parameters = [])
 */
class CampaignNoteRepository extends ModelRepository
{
    protected $modelClassName = CampaignNote::class;

    protected $rules = [
        'name'        => 'required',
        'campaign_id' => 'required',
        'type'        => 'required',
        'content'     => 'required',
    ];
}
