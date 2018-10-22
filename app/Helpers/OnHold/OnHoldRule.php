<?php

namespace App\Helpers\OnHold;

use App\Events\Campaign\OnHold;
use App\Models\Campaign;
use App\Models\User;

abstract class OnHoldRule
{
    /** @var string $name */
    protected $name = null;

    /** @var string $category */
    protected $category = null;

    /** @var string $notification */
    protected $notification = null;

    /**
     * @param Campaign $campaign
     * @param User     $user
     * @return bool
     */
    abstract public function match(Campaign $campaign, User $user);

    /**
     * @param Campaign    $campaign
     * @param User        $user
     * @param string|null $reason
     */
    public function process(Campaign $campaign, User $user, $reason = null)
    {
        $campaign->update([
            'state'            => 'on_hold',
            'on_hold_category' => $this->category,
            'on_hold_rule'     => get_class($this),
            'on_hold_actor'    => \Auth::user() ? \Auth::user()->id : null,
            'on_hold_reason'   => $reason,
        ]);

        event(new OnHold($campaign->id, $this->getName()));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Notifications\Notification
     */
    public function getNotification($campaign)
    {
        if ($this->notification) {
            $notification = $this->notification;

            return new $notification($campaign);
        }

        return null;
    }

    public function returnResult($campaign, $success)
    {
        campaign_repository()->find($campaign->id)->track('on_hold_rule: '.$this->getName().'['.($success ? 'match' : 'no match').']', ['rule' => $this->getName(), 'match' => $success]);

        return $success;
    }
}