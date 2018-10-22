<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrepareProcessingJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $campaignId;

    function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    public function handle()
    {
        $campaign = campaign_repository()->find($this->campaignId);
        $quoteFinal = null;
        $quoteFinalFirst = null;
        foreach ($campaign->quotes as $index => $quote) {
            $quoteFinal = $campaign->quoteQuantity($quote, $campaign->getAuthorizedQuantity());
            $quote->update([
                'quote_final' => $quoteFinal,
            ]);
            if ($index == 0) {
                $quoteFinalFirst = $quoteFinal;
            }
        }

        $campaign->quote_final = $quoteFinalFirst;
        $campaign->updateOrdersWithFinalQuote();
        $campaign->processed_at = date('Y-m-d H:i:s');
        $campaign->save();
        $campaign->track('processing_payment');
    }
}
