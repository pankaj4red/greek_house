<?php

namespace App\Reports;

use App\Contracts\Report\Report;

class CampaignShippingFile extends Report
{
    public function generate()
    {
        if (! $this->get('campaign_id')) {
            throw new \Exception('Missing campaign_id in CampaignSalesReport');
        }
        $campaign = campaign_repository()->find($this->get('campaign_id'));
        if ($campaign == null) {
            throw new \Exception('Unknown Campaign');
        }

        $header = [
            'Order ID (required)',
            'Order Date',
            'Order Value',
            'Requested Service',
            'Ship To - Name',
            'Ship To - Company',
            'Ship To - Address 1',
            'Ship To - Address 2',
            'Ship To - Address 3',
            'Ship To - State/Province',
            'Ship To - City',
            'Ship To - Postal Code',
            'Ship To - Country',
            'Ship To - Phone',
            'Ship To - Email',
            'Total Weight in Oz',
            'Dimensions - Length',
            'Dimensions - Width',
            'Dimensions - Height',
            'Notes - From Customer',
            'Notes - Internal',
            'Gift Wrap?',
            'Gift Message',
        ];

        $body = [];
        foreach ($campaign->success_orders as $order) {
            $orderLine = [];
            $orderLine[] = $order->id;
            $orderLine[] = date('m/d/Y', strtotime($order->created_at));
            $orderLine[] = number_format($order->total, 2, '.', '');
            $orderLine[] = '';
            $orderLine[] = $order->getShippingName();
            $orderLine[] = '';
            $orderLine[] = $order->getShippingAddress()->line1;
            $orderLine[] = $order->getShippingAddress()->line2;
            $orderLine[] = '';
            $orderLine[] = $order->getShippingAddress()->state;
            $orderLine[] = $order->getShippingAddress()->city;
            $orderLine[] = $order->getShippingAddress()->zip_code;
            $orderLine[] = $order->getShippingAddress()->country;
            $orderLine[] = $order->getShippingPhone();
            $orderLine[] = $order->getShippingEmail();
            $orderLine[] = '';
            $orderLine[] = '';
            $orderLine[] = '';
            $orderLine[] = '';
            $orderLine[] = '';
            $orderLine[] = '';
            $orderLine[] = 'FALSE';
            $orderLine[] = '';

            $body[] = $orderLine;
        }

        return [
            'header' => $header,
            'body'   => $body,
            'footer' => [],
        ];
    }
}
