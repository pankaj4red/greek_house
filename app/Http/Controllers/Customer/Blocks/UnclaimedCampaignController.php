<?php

namespace App\Http\Controllers\Customer\Blocks;

use App;
use App\Helpers\AccessToken\AccessTokenManager;
use App\Http\Controllers\BlockController;

class UnclaimedCampaignController extends BlockController
{
    /** @var AccessTokenManager $accessTokenManager */
    protected $accessTokenManager;

    /**
     * BlockController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->accessTokenManager = App::make(AccessTokenManager::class);
    }

    public function block()
    {
        $this->force(['admin', 'support', 'designer', 'art_director']);

        return $this->view('blocks.block.unclaimed_campaign');
    }
}
