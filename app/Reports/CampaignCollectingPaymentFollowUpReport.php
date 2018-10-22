<?php

namespace App\Reports;

use App\Contracts\Report\Report;

class CampaignCollectingPaymentFollowUpReport extends Report
{
    public function generate()
    {
        $campaigns = campaign_repository()->getCurrentlyCollectingPaymentFollowUp();

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
            'Age',
            'Order Close Date',
        ];

        $age = 0;
        $body = [];
        foreach ($campaigns as $campaign) {
            $quantityOrdered = 0;
            foreach ($campaign->authorized_success_orders as $order) {
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
            $orderLine[] = $age;
            $orderLine[] = $campaign->close_date ? date('m/d/Y', strtotime($campaign->close_date)) : 'N/A';
            $body[] = $orderLine;
        }

        return [
            'header' => $header,
            'body'   => $body,
            'footer' => [],
        ];
    }
}
