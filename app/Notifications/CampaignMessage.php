<?php

namespace App\Notifications;

class CampaignMessage implements NotificationMessage
{
    public $campaignId;

    public $userId;

    protected $lines = [];

    public function __construct($campaignId, $userId = null)
    {
        $this->campaignId = $campaignId;
        $this->userId = $userId;
    }

    public function subject($subject)
    {
        // Ignore

        return $this;
    }

    public function hello($name)
    {
        return $this->line('Hey '.$name);
    }

    public function line($line)
    {
        $this->lines[] = $line;

        return $this;
    }

    public function getMessage()
    {
        return implode(PHP_EOL, array_merge($this->lines, ['Best,', 'Greek House']));
    }
}