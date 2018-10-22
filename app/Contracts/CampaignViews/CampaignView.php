<?php

namespace App\Contracts\CampaignViews;

use App\Http\Controllers\BlockController;
use App\Models\Campaign;
use Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class CampaignView
{
    /**
     * @var Campaign
     */
    protected $campaign = null;

    /**
     * @var array|BlockController[]
     */
    protected $left = [];

    /**
     * @var array|BlockController[]
     */
    protected $right = [];

    /**
     * @var array|BlockController[]
     */
    protected $both = [];

    /**
     * @var array|BlockController[]
     */
    protected $rightTabs = [];

    /**
     * @var bool
     */
    protected $v2 = false;

    /**
     * @param Campaign $campaign
     */
    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * @param BlockController $block
     */
    public function addLeft(BlockController $block)
    {
        $this->left[] = $block;
    }

    /**
     * @param BlockController $block
     */
    public function addRight(BlockController $block)
    {
        $this->right[] = $block;
    }

    /**
     * @param BlockController $block
     */
    public function addBoth(BlockController $block)
    {
        $this->both[] = $block;
    }

    /**
     * @return bool
     */
    public function isV2()
    {
        return $this->v2;
    }

    /**
     * @return BlockController[]
     */
    public function getBoth()
    {
        return $this->both;
    }

    /**
     * @return BlockController[]
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @return BlockController[]
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @return array|BlockController
     * @throws HttpResponseException
     */

    public function getRightTabs()
    {
        $tabs = [];
        foreach ($this->rightTabs as $tab) {
            $tabs[] = $tab;
        }

        return $tabs;
    }

    /**
     * @param int $id
     * @return BlockController|null
     */
    public function getRightTab($id)
    {
        foreach ($this->rightTabs as $tab) {
            if ($tab->id == $id) {
                return $tab;
            }
        }

        return null;
    }

    /**
     * @param string $viewName
     */
    public function force($viewName)
    {
        if (! Auth::user() || ! Auth::user()->hasView($this->campaign->id, $viewName)) {
            abort(403);
        }
    }

    /**
     * @param  int            $tabId
     * @param  string         $tabCaption
     * @param BlockController $block
     */
    public function addRightTab($tabId, $tabCaption, BlockController $block)
    {
        foreach ($this->rightTabs as $tab) {
            if ($tab->id == $tabId) {
                $tab->blocks[] = $block;

                return;
            }
        }

        $this->rightTabs[] = (object) ['id' => $tabId, 'caption' => $tabCaption, 'blocks' => [$block]];
    }
}
