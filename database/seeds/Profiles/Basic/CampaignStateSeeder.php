<?php

class CampaignStateSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        campaign_state_repository()->create([
            'code'             => 'on_hold',
            'caption'          => 'On Hold',
            'caption_customer' => 'On Hold',
        ]);
        campaign_state_repository()->create([
            'code'             => 'campus_approval',
            'caption'          => 'CM Approval',
            'caption_customer' => 'CM Approval',
        ]);
        campaign_state_repository()->create([
            'code'             => 'awaiting_design',
            'caption'          => 'Awaiting Design',
            'caption_customer' => 'Awaiting Design',
        ]);
        campaign_state_repository()->create([
            'code'             => 'awaiting_approval',
            'caption'          => 'Awaiting Approval',
            'caption_customer' => 'Awaiting Approval',
        ]);
        campaign_state_repository()->create([
            'code'             => 'revision_requested',
            'caption'          => 'Revision Requested',
            'caption_customer' => 'Revision Requested',
        ]);
        campaign_state_repository()->create([
            'code'             => 'awaiting_quote',
            'caption'          => 'Awaiting Greek Licensing Approval',
            'caption_customer' => 'Awaiting Greek Licensing Approval',
        ]);
        campaign_state_repository()->create([
            'code'             => 'collecting_payment',
            'caption'          => 'Collecting Payment',
            'caption_customer' => 'Collecting Payment',
        ]);
        campaign_state_repository()->create([
            'code'             => 'processing_payment',
            'caption'          => 'Processing Payment',
            'caption_customer' => 'Payment Closed | Printing',
        ]);
        campaign_state_repository()->create([
            'code'             => 'fulfillment_ready',
            'caption'          => 'Fulfillment Ready',
            'caption_customer' => 'Payment Closed | Printing',
        ]);
        campaign_state_repository()->create([
            'code'             => 'fulfillment_validation',
            'caption'          => 'F. Validation',
            'caption_customer' => 'Payment Closed | Printing',
        ]);
        campaign_state_repository()->create([
            'code'             => 'printing',
            'caption'          => 'Payment Closed | Printing',
            'caption_customer' => 'Payment Closed | Printing',
        ]);
        campaign_state_repository()->create([
            'code'             => 'shipped',
            'caption'          => 'Shipped',
            'caption_customer' => 'Shipped',
        ]);
        campaign_state_repository()->create([
            'code'             => 'delivered',
            'caption'          => 'Delivered',
            'caption_customer' => 'Delivered',
        ]);
        campaign_state_repository()->create([
            'code'             => 'cancelled',
            'caption'          => 'Cancelled',
            'caption_customer' => 'Cancelled',
        ]);
    }
}