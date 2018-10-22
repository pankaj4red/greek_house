<?php

namespace App\Repositories\Models;

use App\Models\Campaign;
use App\Models\CampaignState;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * @method CampaignState make()
 * @method Collection|CampaignState[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignState|null find($id)
 * @method CampaignState create(array $parameters = [])
 */
class CampaignStateRepository extends ModelRepository
{
    protected $modelClassName = CampaignState::class;

    /**
     * @param string        $code
     * @param bool          $includeHtml
     * @param Campaign|null $campaign
     * @param User|null     $user
     * @return string
     */
    public function caption($code, $includeHtml = false, Campaign $campaign = null, User $user = null)
    {
        /** @var CampaignState $campaignState */
        $campaignState = $this->model->where('code', $code)->first();
        if (! $campaignState) {
            dd(['caption' => $code]);
        }

        return $campaignState->caption($user, $campaign, $includeHtml);
    }

    public function options($nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->model->orderBy('id', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->code] = $entry->caption;
        }

        return $options;
    }
}
