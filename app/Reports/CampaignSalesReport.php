<?php

namespace App\Reports;

use App\Contracts\Report\Report;

class CampaignSalesReport extends Report
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
        $productSizes = product_size_repository()->getByProductId($campaign->product_colors->first()->product_id);

        $header = [
            'Campaign #',
            'Order #',
            'Product - Color',
            'Name',
            'School',
            'Chapter',
            'Date',
        ];
        $sizes = [];
        foreach ($productSizes as $size) {
            $header[] = $size->size->short;
            $sizes[] = $size->size->short;
        }
        foreach ($campaign->authorized_success_orders as $order) {
            foreach ($order->entries as $entry) {
                $found = false;
                foreach ($sizes as $index => $size) {
                    if ($size == $entry->size->short) {
                        $found = true;
                        break;
                    }
                }
                if ($found == false) {
                    $header[] = $entry->size->short;
                    $sizes[] = $entry->size->short;
                }
            }
        }
        $header[] = 'Total';
        $header[] = 'Shipping Address';

        $body = [];
        foreach ($campaign->authorized_success_orders as $order) {
            foreach ($order->entries as $entry) {
                $orderLine = [];
                $orderLine[] = $order->campaign_id;
                $orderLine[] = $order->id;
                $orderLine[] = $entry->product_color->product->name.' - '.$entry->product_color->name;
                $orderLine[] = $order->getContactFullName();
                $orderLine[] = $order->contact_school ?? $campaign->contact_school;
                $orderLine[] = $order->contact_chapter ?? $campaign->contact_chapter;
                $orderLine[] = $order->created_at->format('m/d/Y');

                foreach ($sizes as $size) {
                    if ($size == $entry->size->short) {
                        $orderLine[] = $entry->quantity;
                    } else {
                        $orderLine[] = 0;
                    }
                }
                $orderLine[] = $entry->quantity;
                $orderLine[] = $order->getShippingAddress()->line1.' '.$order->getShippingAddress()->line2.', '.$order->getShippingAddress()->city.' '.$order->getShippingAddress()->zip_code.' '.$order->getShippingAddress()->state;
                $body[] = $orderLine;
            }
        }

        return [
            'header' => $header,
            'body'   => $body,
            'footer' => [],
        ];
    }
}
