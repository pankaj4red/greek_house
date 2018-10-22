<?php

namespace App\Reports;

use App\Contracts\Report\Report;
use App\Models\Campaign;

class CampaignDeadlineFollowUpReport extends Report
{
    public function generate()
    {
        $campaigns = campaign_repository()->getCurrentlyDeadlineFollowUp();

        $header = [
            'Campaign #',
            'Campaign URL',
            'Customer First Name',
            'Customer Last Name',
            'Email',
            'Phone #',
            '# of Design Hours',
            'Quantity Ordered',
            'Estimated Quantity range',
            'Delivery Due Date',
            'Age',
        ];

        $age = 0;
        $body = [];
        /** @var Campaign $campaign */
        foreach ($campaigns as $campaign) {
            $quantityOrdered = 0;
            foreach ($campaign->success_orders as $order) {
                $quantityOrdered += $order->quantity;
            }

            $orderLine = [];
            $orderLine[] = $campaign->id;
            $orderLine[] = route('dashboard::details', [$campaign->id]);
            $orderLine[] = $campaign->contact_first_name;
            $orderLine[] = $campaign->contact_last_name;
            $orderLine[] = $campaign->contact_email;
            $orderLine[] = get_phone($campaign->contact_phone) ? get_phone($campaign->contact_phone) : $campaign->contact_phone;
            $orderLine[] = round($campaign->artwork_request->design_minutes / 60, 2);
            $orderLine[] = $quantityOrdered;
            $orderLine[] = estimated_quantity_by_code($campaign->getCurrentArtwork()->design_type, $campaign->estimated_quantity)->code;
            $orderLine[] = ($campaign->date && $campaign->flexible == 'no') ? date('m/d/Y', strtotime($campaign->date)) : 'N/A';
            $orderLine[] = $age;
            $body[] = $orderLine;
        }

        return [
            'header' => $header,
            'body'   => $body,
            'footer' => [],
        ];
    }
}
