<?php

namespace App\Listeners;

use App\Events\Campaign\OnHold;
use App\Exceptions\QuoteException;
use App\Helpers\OnHold\OnHoldEngine;
use App\Logging\Logger;
use App\Quotes\QuoteGenerator;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CampaignOnHoldInternalNote
{
    use DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param  OnHold $event
     * @return void
     */
    public function handle(OnHold $event)
    {
        $rule = OnHoldEngine::getRule($event->ruleName);
        if (! $rule) {
            Logger::logAlert('Unknown on hold rule: '.$event->ruleName);
        }

        if ($rule->getName() != 'new_customer') {
            return;
        }

        campaign_note_repository()->create([
            'campaign_id' => $event->campaignId,
            'type'        => 'on_hold_note',
            'content'     => $this->getContent($event->campaignId),
        ]);
    }

    /**
     * Creates the content of the internal note
     *
     * @param integer $campaignId
     * @return string
     */
    public function getContent($campaignId)
    {
        $campaign = campaign_repository()->find($campaignId);

        $product = $campaign->product_colors->first()->product;//todo:quoting
        $artwork = $campaign->artwork_request;
        $colors = '';
        if ($artwork->print_front) {
            if ($colors) {
                $colors .= ' / ';
            }
            $colors .= $artwork->print_front_colors.' '.str_plural('color', $artwork->print_front_colors).' on front';
        }
        if ($artwork->print_back) {
            if ($colors) {
                $colors .= ' / ';
            }
            $colors .= $artwork->print_back_colors.' '.str_plural('color', $artwork->print_back_colors).' on back';
        }
        if ($artwork->print_pocket) {
            if ($colors) {
                $colors .= ' / ';
            }
            $colors .= $artwork->print_pocket_colors.' '.str_plural('color', $artwork->print_pocket_colors).' on pocket';
        }
        if ($artwork->print_sleeve) {
            if ($colors) {
                $colors .= ' / ';
            }
            $colors .= $artwork->print_sleeve_colors.' '.str_plural('color', $artwork->print_front_colors).' on sleeve';
        }

        $from = null;
        $to = null;
        try {
            $quickQuote = QuoteGenerator::quickSimpleQuote($artwork->design_type, $product->id, $artwork->print_front ? $artwork->print_front_colors : 0, $artwork->print_back ? $artwork->print_back_colors : 0, $artwork->print_pocket ? $artwork->print_pocket_colors : 0, $artwork->print_sleeve ? $artwork->print_sleeve_colors : 0, estimated_quantity_by_code($artwork->design_type, $campaign->estimated_quantity)->from, estimated_quantity_by_code($artwork->design_type, $campaign->estimated_quantity)->to);

            $from = $quickQuote->getPricePerUnitFrom();
            $to = $quickQuote->getPricePerUnitTo();
        } catch (QuoteException $ex) {
            Logger::logAlert('Quoting error on OnHoldBudgetNotification', ['campaign' => $campaign->toArray(), 'artwork' => $artwork->toArray(), 'product' => $product->toArray()]);
        }

        if ($from && $to) {
            return 'The estimated price per piece comes out to {'.money($to).' - '.money($from).'} for '.$product->sku.' - '.$product->name.' w/ './/TODO
                $colors.' for '.$campaign->estimated_quantity.' pieces.';
        }

        return 'Quoting error. Please report this issue to the development team';
    }
}
