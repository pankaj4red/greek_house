<?php

namespace App\Reports;

use App\Contracts\Report\Report;

class CampaignFulfillmentReport extends Report
{
    public function generate()
    {
        if (! $this->get('campaign_id')) {
            throw new \Exception('Missing campaign_id in CampaignFulfillmentReport');
        }
        $campaign = campaign_repository()->find($this->get('campaign_id'));
        if ($campaign == null) {
            throw new \Exception('Unknown Campaign');
        }
        $productSizes = product_size_repository()->getByProductId($campaign->product_colors->first()->product_id);

        $header = [
            'Campaign #',
            'Order #',
            'Name',
            'User Name',
            'Size',
            'Quantity',
            'Shipping Address',
            'Type of Shipment',
            'School',
            'Chapter',
        ];
        $total = 0;
        $allSizes = [];
        foreach ($productSizes as $size) {
            $header[] = $size->size->short;
            $allSizes[$size->size->short] = 0;
        }
        foreach ($campaign->success_orders as $order) {
            foreach ($order->entries as $entry) {
                $found = false;
                foreach ($allSizes as $size => $quantity) {
                    if ($size == $entry->size->short) {
                        $found = true;
                        break;
                    }
                }
                if ($found == false) {
                    $header[] = $entry->size->short;
                    $allSizes[$entry->size->short] = 0;
                }
            }
        }

        $body = [];
        foreach ($campaign->success_orders as $order) {
            $quantity = 0;
            $sizeName = '-';
            foreach ($allSizes as $size => $quantity) {
                foreach ($order->entries as $entry) {
                    if ($size == $entry->size->short) {
                        $quantity = $entry->quantity;
                        $allSizes[$size] += $entry->quantity;
                        $total += $entry->quantity;
                        $sizeName = $size;
                        break;
                    }
                }
            }
            $orderLine = [];
            $orderLine[] = $campaign->id;
            $orderLine[] = $order->id;
            $orderLine[] = $campaign->name;
            $orderLine[] = $order->getContactFullName();
            $orderLine[] = $sizeName;
            $orderLine[] = $quantity;
            $orderLine[] = $order->getShippingAddress()->line1.' '.$order->getShippingAddress()->line2.', '.$order->getShippingAddress()->city.' '.$order->getShippingAddress()->zip_code.' '.$order->getShippingAddress()->state;
            $orderLine[] = $order->shipping_type == 'group' ? 'Group Shipment' : 'Individual Shipment';
            $orderLine[] = $order->contact_school;
            $orderLine[] = $order->contact_chapter;
            $body[] = $orderLine;
        }

        $footer = [];
        $footer[] = ['', '', '', '', 'Total', $total];
        $footer[] = ['', 'Size Totals'];
        foreach ($allSizes as $short => $quantity) {
            $footer[] = ['', $short, $quantity];
        }
        $footer[] = ['', 'Total', $total];

        return [
            'header' => $header,
            'body'   => $body,
            'footer' => $footer,
        ];
    }
}
