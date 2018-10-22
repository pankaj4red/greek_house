<?php

namespace App\Helpers\OnHold;

use App\Logging\Logger;
use App\Models\Campaign;
use App\Models\User;
use App\Notifications\CampaignOnHold\OnHoldBudgetNotification;
use App\Quotes\ScreenPrinterQuote;

class BudgetRule extends OnHoldRule
{
    protected $name = 'budget';

    protected $category = 'budget';

    protected $notification = OnHoldBudgetNotification::class;

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
        if ($campaign->budget == 'no') {
            return $this->returnResult($campaign, false);
        }
        $campaign = $campaign->fresh('artwork_request');
        $quote = null;
        switch ($campaign->artwork_request->design_type) {
            case 'screen':
                $quote = new ScreenPrinterQuote();
                break;
            case 'embroidery':
                $quote = new ScreenPrinterQuote();
                break;
            default:
                return $this->returnResult($campaign, false);
        }

        $maxPrice = 0;
        foreach ($campaign->product_colors as $productColor) {
            if ($productColor->product->price > $maxPrice) {
                $maxPrice = $productColor->product->price;
            }
        }

        $quote->quote([
            'product_name'            => '',
            'product_cost'            => $maxPrice,
            'color_front'             => $campaign->artwork_request->print_front ? $campaign->artwork_request->print_front_colors : 0,
            'color_back'              => $campaign->artwork_request->print_back ? $campaign->artwork_request->print_back_colors : 0,
            'color_left'              => $campaign->artwork_request->print_sleeve && in_array($campaign->artwork_request->print_sleeve_preferred, ['both', 'left']) ? $campaign->artwork_request->print_sleeve_colors : 0,
            'color_right'             => $campaign->artwork_request->print_sleeve && in_array($campaign->artwork_request->print_sleeve_preferred, ['both', 'right']) ? $campaign->artwork_request->print_sleeve_colors : 0,
            'black_shirt'             => $campaign->artwork_request->designer_black_shirt ? 'yes' : 'no',
            'estimated_quantity_from' => estimated_quantity_by_code($campaign->artwork_request->design_type, $campaign->estimated_quantity)->from,
            'estimated_quantity_to'   => estimated_quantity_by_code($campaign->artwork_request->design_type, $campaign->estimated_quantity)->from,
            'design_hours'            => null,
            'markup'                  => null,
        ]);

        if (! $quote->isSuccess()) {
            Logger::logAlert('Error while trying to process quote for on hold budget rule: '.implode('||', $quote->getErrors()));

            return $this->returnResult($campaign, false);
        }

        return $this->returnResult($campaign, budget_range($campaign->budget_range)[1] < $quote->getPricePerUnitTo());
    }
}