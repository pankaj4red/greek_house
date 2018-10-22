<?php

namespace App\Traits;

trait ChecksCampaignPermission
{
    public function checkCampaignPermissions($campaign)
    {
        $access = false;
        if (\Auth::user()->isType(['admin', 'support', 'designer', 'junior_designer', 'art_director', 'decorator'])) {
            $access = true;
        }
        if (\Auth::user()->id == $campaign->user_id) {
            $access = true;
        }
        if ($access == false) {
            $user = $campaign->user;
            if ($user == null && $campaign->user_id != null) {
                $user = campaign_repository()->find($campaign->user_id);
            }
            if ($user != null && $user->account_manager_id == \Auth::user()->id) {
                $access = true;
            }
        }
        if ($access == false) {
            return form()->error('Access Denied')->route('dashboard::index');
        }

        return null;
    }
}
