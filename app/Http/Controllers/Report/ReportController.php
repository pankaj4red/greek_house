<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Reports\CampaignFulfillmentReport;
use App\Reports\CampaignSalesReport;
use App\Reports\CampaignShippingFile;
use mikehaertl\pdftk\Pdf;

class ReportController extends Controller
{
    public function getCampaignSales($id)
    {
        $report = \App::make(CampaignSalesReport::class);
        $report->put('campaign_id', $id);
        header('Content-Disposition: attachment; filename="'.$id.'.csv"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        return $report->csv();
    }

    public function getCampaignFulfillment($id)
    {
        $report = \App::make(CampaignFulfillmentReport::class);
        $report->put('campaign_id', $id);
        header('Content-Disposition: attachment; filename="'.$id.'.csv"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        return $report->csv();
    }

    public function getShippingFile($id)
    {
        if (! \Auth::user()) {
            \App::abort(403, 'Access denied');
        }
        if (! \Auth::user()->hasCampaign($id) && ! \Auth::user()->isType(['admin', 'support', 'decorator'])) {
            \App::abort(403, 'Access denied');
        }
        $report = \App::make(CampaignShippingFile::class);
        $report->put('campaign_id', $id);
        header('Content-Disposition: attachment; filename="shipping_file_'.$id.'.csv"');
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");

        return $report->csv();
    }

    public function getShippingPdf($id)
    {
        if (! \Auth::user()) {
            \App::abort(403, 'Access denied');
        }
        if (! \Auth::user()->hasCampaign($id) && ! \Auth::user()->isType(['admin', 'support', 'decorator'])) {
            \App::abort(403, 'Access denied');
        }
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            \App::abort(404, 'Not Found');
        }
        $orderGroups = [];
        foreach ($campaign->success_orders as $order) {
            foreach ($order->entries as $entry) {
                if (! isset($orderGroups[$order->contact_email.'#'.$entry->size->short])) {
                    $orderGroups[$order->contact_email.'#'.$entry->size->short] = [
                        'name'     => $order->contact_first_name.' '.$order->contact_last_name,
                        'size'     => $entry->size->short,
                        'quantity' => 0,
                    ];
                }
                $orderGroups[$order->contact_email.'#'.$entry->size->short]['quantity'] += $entry->quantity;
            }
        }
        $fields = ['Order Number and Name' => $campaign->id.' - '.$campaign->name];
        $files = [new Pdf(public_path('shipping_form.pdf'))];
        $index = 0;
        $orderGroupSorted = sortOrderGroups($orderGroups);
        foreach ($orderGroupSorted as $group) {
            $subIndex = (($index % 29) + 1);
            $fields['Name Row '.($subIndex >= 28 ? ($subIndex + 1) : $subIndex)] = $group['name'];
            $fields['SIZERow'.$subIndex] = $group['size'];
            $fields['QUANTITYRow'.$subIndex] = $group['quantity'];

            $index++;
            if ($index % 29 == 0 && $index < count($orderGroupSorted)) {
                $files[count($files) - 1]->fillForm($fields);
                $files[count($files) - 1]->flatten();
                $files[] = new Pdf(public_path('shipping_form.pdf'));
                $fields = ['Order Number and Name' => $campaign->id.' - '.$campaign->name];
            }
        }
        $files[count($files) - 1]->fillForm($fields);
        $files[count($files) - 1]->flatten();
        $finalPdf = new Pdf($files);
        $finalPdf->needAppearances();
        if (! $finalPdf->send('shipping_file_'.$campaign->id.'.pdf', false)) {
            throw new \Exception('Could not create PDF: '.$finalPdf->getError());
        }
    }
    /* protected function sortOrderGroups($orderGroups)
     {
         usort($orderGroups, function ($a, $b) {
             return strcmp($a['name'], $b['name']);
         });
         
         return $orderGroups;
     }*/
}
