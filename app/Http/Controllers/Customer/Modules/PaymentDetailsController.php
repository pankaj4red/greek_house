<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Http\Controllers\ModuleController;
use App\Reports\CampaignSalesReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentDetailsController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
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

        $timeLeft = 0;
        $timeLeftUnit = '';

        if ($this->getCampaign()->state == 'collecting_payment') {
            $timeLeft = 0;
            $timeLeftUnit = '';

            $closeDate = new \DateTime($campaign->close_date);
            $now = new \DateTime(date('Y-m-d H:i:s'));
            $difference = $closeDate->diff($now);

            if ($difference->s) {
                $timeLeft = $difference->s;
                $timeLeftUnit = 'second'.($timeLeft > 1 ? 's' : '');
            }
            if ($difference->i) {
                $timeLeft = $difference->i;
                $timeLeftUnit = 'minute'.($timeLeft > 1 ? 's' : '');
            }
            if ($difference->h) {
                $timeLeft = $difference->h;
                $timeLeftUnit = 'hour'.($timeLeft > 1 ? 's' : '');
            }
            if ($difference->days) {
                $timeLeft = $difference->days;
                $timeLeftUnit = 'day'.($timeLeft > 1 ? 's' : '');
            }
        }

        return $this->view('v3.customer.dashboard.modules.payment_details.payment_details_block', [
            'paymentCloseDate' => $paymentCloseDate,
            'timeLeft'         => $timeLeft,
            'timeLeftUnit'     => $timeLeftUnit,
            'sizes'            => ['sizes' => $sizes, 'total' => $total, 'subTotal' => $subTotal],
        ]);
    }

    /**
     * @param         $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postCloseCampaign($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if ($this->getCampaign()->state != 'collecting_payment') {
            return form()->error('Action can only be performed when campaign is collecting payment.')->back();
        }

        if (! \Auth::user()->isType(['admin', 'support']) && ! $this->getCampaign()->hasMetEstimatedQuantity()) {
            return form()->error('Campaign does not met minimum quantity')->back();
        }

        $notificationType = $this->getCampaign()->closePayment();
        $this->getCampaign()->notificationClosePayment($notificationType);
        success('Campaign Successfully Closed');

        return form()->back();
    }

    /**
     * @param         $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postExtendDate($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if ($this->getCampaign()->state != 'collecting_payment') {
            return form()->error('Action can only be performed when campaign is collecting payment.')->back();
        }

        form($request)->validate([
            'close_date' => 'required|date',
        ]);
        $this->getCampaign()->update([
            'close_date'            => Carbon::parse($request->get('close_date')),
            'closing_24h_mail_sent' => false,
        ]);

        return form()->success('Campaign Successfully Extended')->back();
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function getSales($id)
    {
        $this->forceCanBeAccessed();

        $productSizes = product_size_repository()->getByProductId($this->getCampaign()->product_colors->first()->product_id);
        $salesReport = \App::make(CampaignSalesReport::class);
        $salesReport->put('campaign_id', $id);

        return $this->view('v3.customer.dashboard.modules.payment_details.payment_details_sales', [
            'sizes'  => $productSizes,
            'report' => $salesReport,
        ]);
    }
}
