<?php

namespace App\Notifications\CampaignOnHold;

use App\Exceptions\QuoteException;
use App\Logging\Logger;
use App\Models\Campaign;
use App\Notifications\CampaignMessage;
use App\Notifications\Channels\SupportMessageChannel;
use App\Notifications\GHMessage;
use App\Notifications\NotificationMessage;
use App\Quotes\QuoteGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OnHoldProductNotification extends Notification
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
        $product = $this->campaign->product_colors->first()->product;
        $artwork = $this->campaign->artwork_request;

        $from = null;
        $to = null;
        try {
            $quickQuote = QuoteGenerator::quickSimpleQuote($artwork->design_type, $product->id, $artwork->print_front ? $artwork->print_front_colors : 0, $artwork->print_back ? $artwork->print_back_colors : 0, $artwork->print_pocket ? $artwork->print_pocket_colors : 0, $artwork->print_sleeve ? $artwork->print_sleeve_colors : 0, estimated_quantity_by_code($artwork->design_type, $this->campaign->estimated_quantity)->from, estimated_quantity_by_code($artwork->design_type, $this->campaign->estimated_quantity)->to);

            $from = $quickQuote->getPricePerUnitFrom();
            $to = $quickQuote->getPricePerUnitTo();
        } catch (QuoteException $ex) {
            Logger::logAlert('Quoting error on OnHoldBudgetNotification', ['campaign' => $this->campaign->toArray(), 'artwork' => $artwork->toArray(), 'product' => $product->toArray()]);
        }

        $message->subject('Your Order is in Review!')->hello($notifiable->first_name)->line('Your order is currently being reviewed by our customer success team to ensure this campaign is successful. You have selected a PREMIUM product, so while you have excellent taste, we want to make sure it\'s within the price range you\'re looking for. [ul]'.'[li]Product '.$product->sku.' - '.$product->name.'[/li]'.($artwork->print_front ? '[li]'.$artwork->print_front_colors.' '.str_plural('color', $artwork->print_front_colors).' on front[/li]' : '').($artwork->print_back ? '[li]'.$artwork->print_back_colors.' '.str_plural('color', $artwork->print_back_colors).' on back[/li]' : '').($artwork->print_pocket ? '[li]'.$artwork->print_pocket_colors.' '.str_plural('color', $artwork->print_pocket_colors).' on pocket[/li]' : '').($artwork->print_sleeve ? '[li]'.$artwork->print_sleeve_colors.' '.str_plural('color', $artwork->print_sleeve_colors).' on sleeves[/li]' : '').'[li]'.$this->campaign->estimated_quantity.' pieces[/li][/ul]');
        if ($from && $to) {
            $message->line('Estimated price per piece: '.money($to).' - '.money($from));
        }

        return $message->line('If the estimated price is out of your budget, we can help come up with ways to lower the price (such as using a different garment or less colors).')->line('If the estimated price above is okay, please reply "APPROVE" on this message board and we\'ll go ahead and get started! ');
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
            'notification' => 'on_hold_expensive_product',
            'user_id'      => $this->campaign->user_id,
        ];
    }
}
