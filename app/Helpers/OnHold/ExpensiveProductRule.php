<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldProductNotification;

class ExpensiveProductRule extends OnHoldRule
{
    protected $name = 'product';

    protected $category = 'product';

    protected $notification = OnHoldProductNotification::class;

    /**
     * @param Campaign $campaign
     * @param User     $user
     * @return bool
     */
    public function match(Campaign $campaign, User $user)
    {
        if ($user->type->isStaff()) {
            return $this->returnResult($campaign, false);
        }

        $maxPrice = 0;
        foreach ($campaign->product_colors as $productColor) {
            if ($productColor->product->price > $maxPrice) {
                $maxPrice = $productColor->product->price;
            }
        }

        return $this->returnResult($campaign, $maxPrice >= config('greekhouse.product.expensive_threshold'));
    }
}