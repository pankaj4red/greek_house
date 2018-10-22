<?php

namespace App\Helpers\OnHold;

use App\Models\Campaign;
use App\Models\User;

class OnHoldEngine
{
    protected static $rules = [
        ActionNeededRule::class,
        OnlyCancelledCampaignsRule::class,
        BudgetRule::class,
        ExpensiveProductRule::class,
        LowSuccessRateRule::class,
        RejectedByDesignerGenericRule::class,
        RejectedByDesignerSpecificRule::class,
        TooManyDesignRequestsRule::class,
        DuplicateRequestRule::class,
        NewCustomerRule::class,
    ];

    protected static $activeRules = [
        NewCustomerRule::class,
        ActionNeededRule::class,
        OnlyCancelledCampaignsRule::class,
        LowSuccessRateRule::class,
        TooManyDesignRequestsRule::class,
        BudgetRule::class,
        ExpensiveProductRule::class,
        DuplicateRequestRule::class,
    ];

    /**
     * @param Campaign $campaign
     * @param User     $user
     * @return bool
     */
    public static function process(Campaign $campaign, User $user)
    {
        foreach (static::$activeRules as $ruleClass) {
            /** @var OnHoldRule $rule */
            $rule = new $ruleClass();
            if ($rule->match($campaign, $user)) {
                $rule->process($campaign, $user);

                return true;
            }
        }

        return false;
    }

    public static function getRule($name)
    {
        foreach (static::$rules as $ruleClass) {
            /** @var OnHoldRule $rule */
            $rule = new $ruleClass();
            if ($rule->getName() == $name) {
                return $rule;
            }
        }

        return null;
    }
}