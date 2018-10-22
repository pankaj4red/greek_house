<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;

/**
 * @property integer $id
 * @property string  $code
 * @property string  $caption
 * @property string  $caption_customer
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class CampaignState extends Model
{
    protected $table = 'campaign_states';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];

    /**
     * @param User|null     $user
     * @param Campaign|null $campaign
     * @return bool
     */
    public function isActionRequired($user = null, $campaign = null)
    {
        switch ($this->code) {
            case 'on_hold':
                return $user && $user->isType(['admin', 'support']);
            case 'campus_approval':
                return $user && $user->isType('account_manager');
            case 'awaiting_design':
                return $user && $user->isType(['designer', 'art_director']);
            case 'awaiting_approval':
                return $user && $user->isType(['customer', 'sales_rep']);
            case 'revision_requested':
                return $user && $user->isType(['customer', 'sales_rep']);
            case 'awaiting_quote':
                return $user && $user->isType(['admin', 'support']);
            case 'collecting_payment':
                return $user && $user->isType(['customer', 'sales_rep']);
            case 'processing_payment':
                return false;
            case 'fulfillment_ready':
                return $user && $user->isType(['admin', 'support']);
            case 'fulfillment_validation':
                if ($campaign) {
                    if ($campaign->fulfillment_valid) {
                        return $user && $user->isType('decorator');
                    } else {
                        return $user && $user->isType(['designer', 'art_director']);
                    }
                }

                return false;
            case 'printing':
                return $user && $user->isType('decorator');
            case 'shipping':
                return false;
            case 'delivered':
                return false;
            case 'cancelled':
                return false;
        }

        return false;
    }

    /**
     * @param User|null     $user
     * @param Campaign|null $campaign
     * @param bool          $includeHtml
     * @return bool
     */
    public function caption($user = null, $campaign = null, $includeHtml = false)
    {
        $caption = $this->caption;
        if ($this->code == 'fulfillment_validation' && $campaign && ! $campaign->fulfillment_valid) {
            if ($campaign->fulfillment_invalid_reason == 'Artwork') {
                $caption = 'Bad Artwork';
            }
            if ($campaign->fulfillment_invalid_reason == 'Garment') {
                $caption = 'Bad Garment';
            }
            if ($campaign->fulfillment_invalid_reason == 'Other') {
                $caption = 'Fulfillment Issues';
            }
        }
        if ($user && ! $user->isType(['admin', 'support', 'art_director', 'designer', 'junior_designer', 'decorator'])) {
            $caption = $this->caption_customer;
        }

        $actionRequired = '';
        if ($this->isActionRequired($user, $campaign)) {
            if ($includeHtml) {
                $actionRequired = ' | <span class="action-required">Action Required</span>';
            } else {
                $actionRequired = ' | Action Required';
            }
        }

        $annotation = '';
        if (Auth::user() && Auth::user()->type->isStaff() && $this->code == 'on_hold' && $campaign && $campaign->on_hold_category) {
            $annotation = ' ('.$campaign->on_hold_category;
            if ($campaign->on_hold_category == 'design' && $campaign->on_hold_actor) {
                $annotation .= ' flagged by '.user_repository()->find($campaign->on_hold_actor)->getFullName();
            }
            $annotation .= ')';
        }

        return $caption.$actionRequired.$annotation;
    }
}
