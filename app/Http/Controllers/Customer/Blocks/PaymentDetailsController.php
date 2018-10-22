<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use App\Reports\CampaignSalesReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentDetailsController extends BlockController
{
    public function block()
    {
        $campaign = $this->getCampaign();

        $total = 0;
        $sizes = [];
        $subTotal = 0;
        foreach ($campaign->product_colors as $productColor) {
            $productSizes = product_size_repository()->getByProductId($productColor->product_id);
            foreach ($productSizes as $productSize) {
                $sizes[$productSize->garment_size_id] = [
                    'id'       => $productSize->id,
                    'size_id'  => $productSize->size->id,
                    'short'    => $productSize->size->short,
                    'quantity' => 0,
                ];
            }
        }

        $orders = order_repository()->getByCampaignId($campaign->id, ['authorized', 'authorized_failed', 'success']);
        foreach ($orders as $order) {
            foreach ($order->entries as $entry) {
                if (! isset($sizes[$entry->garment_size_id])) {
                    $sizes[$entry->garment_size_id] = [
                        'id'       => 0,
                        'size_id'  => $entry->garment_size_id,
                        'short'    => $entry->size->short,
                        'quantity' => 0,
                    ];
                }

                $sizes[$entry->garment_size_id]['quantity'] += $entry->quantity;
                $total += $entry->quantity;
            }
            $subTotal += $order->total;
        }
        $paymentCloseDate = [
            'close_date' => '',
            'action'     => 'close',
        ];

        return $this->view('blocks.block.payment_details', [
            'paymentCloseDate' => $paymentCloseDate,
            'sizes'            => ['sizes' => $sizes, 'total' => $total, 'subTotal' => $subTotal],
        ]);
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.payment_details', [
            'additional_pocket' => 0.21,
        ]);
    }

    public function postCloseDate($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if ($this->getCampaign()->state != 'collecting_payment') {
            return form()->error('Action can only be performed when campaign is collecting payment.')->back();
        }
        if ($request->get('action') == 'close') {
            if (\Auth::user()->isType(['admin', 'support']) || $this->getCampaign()->hasMetEstimatedQuantity()) {
                $notificationType = $this->getCampaign()->closePayment();
                $this->getCampaign()->notificationClosePayment($notificationType);
                success('Campaign Successfully Closed');
            } else {
                return form()->error('Campaign does not met minimum quantity')->back();
            }
        } elseif ($request->get('action') == 'extend') {
            form($request)->validate([
                'close_date' => 'required|date',
            ]);
            $this->getCampaign()->update([
                'close_date'            => Carbon::parse($request->get('close_date')),
                'closing_24h_mail_sent' => false,
            ]);

            return form()->success('Campaign Successfully Extended')->back();
        } elseif ($request->get('action') == 'cancel') {
            $this->forceCanBeAccessed('cancel');
            $this->getCampaign()->cancelPayment();

            return form()->success('Campaign Cancelled')->back();
        }

        return form()->back();
    }

    public function getSales($id)
    {
        $this->forceCanBeAccessed();

        $productSizes = product_size_repository()->getByProductId($this->getCampaign()->product_colors->first()->product_id);
        $salesReport = \App::make(CampaignSalesReport::class);
        $salesReport->put('campaign_id', $id);

        return $this->view('blocks.popup.payment_details___sales', [
            'sizes'  => $productSizes,
            'report' => $salesReport,
        ]);
    }
}
