<?php

namespace App\Notifications\CampaignOnHold;

use App\Models\Campaign;
use App\Notifications\CampaignMessage;
use App\Notifications\Channels\SupportMessageChannel;
use App\Notifications\GHMessage;
use App\Notifications\NotificationMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OnHoldNewCustomerNotification extends Notification
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
        return $message->subject('Your Order is in Review!')->hello($notifiable->first_name)->line('Thanks for placing a design request and welcome to Greek House!')->line('We see that this is your first order and want to make sure your experience is perfect. Are you available for a quick call?')->line('You can schedule a time using the following link: [url]https://calendly.com/greekhouse/review[/url]')->line('If you would rather chat here, can you let us know if you have a budget or price per piece you\'re looking for?')->line('Happy to make this work for your chapter! Once we hear back, we\'ll get you a design back within 24 hours.');
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
            'notification' => 'on_hold_new_customer',
            'user_id'      => $this->campaign->user_id,
        ];
    }
}
