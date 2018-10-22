<?php

namespace App\Notifications\CampaignOnHold;

use App\Models\Campaign;
use App\Notifications\CampaignMessage;
use App\Notifications\Channels\SupportMessageChannel;
use App\Notifications\GHMessage;
use App\Notifications\NotificationMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OnHoldDesignSpecificNotification extends Notification
{
    use Queueable;

    public $campaign;

    /**
     * @param Campaign $campaign
     */
    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', SupportMessageChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  NotificationMessage $message
     * @param  mixed               $notifiable
     * @return NotificationMessage
     */
    private function buildMessage($message, $notifiable)
    {
        return $message->subject('Your Order is in Review!')->hello($notifiable->first_name)->line('After further review, our design team rejected your design because '.$this->campaign->getOnHoldReasonCaption())->line('Based on the above reasoning do you have another direction you would like to take the design in?')->line('If so, please post the new description in the messages.')->line('If not, a member of our team will follow-up and provide additional details.')->line('You can also schedule a time to talk using this link: [url]https://calendly.com/greekhouse/review[/url]');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /** @var GHMessage $message */
        $message = $this->buildMessage(new GHMessage(), $notifiable);

        return $message->view('vendor.notifications.text_email');
    }

    /**
     * Sends email to .
     *
     * @param  mixed $notifiable
     * @return CampaignMessage
     */
    public function toSupportMessage($notifiable)
    {
        /** @var CampaignMessage $message */
        $message = $this->buildMessage(new CampaignMessage($this->campaign->id), $notifiable);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notification' => 'on_hold_rejected_by_designer',
            'user_id'      => $this->campaign->user_id,
        ];
    }
}
