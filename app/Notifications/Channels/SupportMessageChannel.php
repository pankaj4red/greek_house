<?php

namespace App\Notifications\Channels;

use App\Notifications\CampaignMessage;
use Illuminate\Notifications\Notification;

class SupportMessageChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var CampaignMessage $message */
        /** @noinspection PhpUndefinedMethodInspection */
        $message = $notification->toSupportMessage($notifiable);

        comment_repository()->create([
            'channel'     => 'customer',
            'campaign_id' => $message->campaignId,
            'user_id'     => $message->userId,
            'body'        => $message->getMessage(),
            'ip'          => \Request::ip(),
        ]);
    }
}