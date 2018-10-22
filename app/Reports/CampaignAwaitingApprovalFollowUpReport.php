<?php

namespace App\Reports;

use App\Contracts\Report\Report;

class CampaignAwaitingApprovalFollowUpReport extends Report
{
    public function generate()
    {
        $campaigns = campaign_repository()->getCurrentlyAwaitingApprovalFollowUp();

        $header = [
            'Campaign #',
            'Campaign URL',
            'Customer First Name',
            'Customer Last Name',
            'Email',
            'Phone #',
            '# of Design Hours',
            'Age',
        ];

        $age = 0;
        $body = [];
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
