<?php

namespace App\CampaignViews;

use App\Contracts\CampaignViews\CampaignView;
use App\Http\Controllers\Customer\Blocks\DesignGalleryController;
use App\Models\Campaign;

class DesignGalleryCampaignView extends CampaignView
{
    /**
     * DesignGalleryCampaignView constructor.
     *
     * @param Campaign $campaign
     */
    public function __construct(Campaign $campaign)
    {
        $this->setCampaign($campaign);
        $this->force('design_gallery');
        clear_access_tokens();

        $this->addBoth(\App::make(DesignGalleryController::class)->configure($campaign->id, [
            'view' => true,
            'edit' => true,
        ]));
    }
}
