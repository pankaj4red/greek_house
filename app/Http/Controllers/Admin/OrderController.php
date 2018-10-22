<?php

namespace app\Http\Controllers\Admin;

use App\Exceptions\BillingErrorException;
use App\Exceptions\NotImplementedException;
use App\Http\Controllers\AdminBaseController;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends AdminBaseController
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_support');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request)
    {
        return view('admin.order.list', [
            'list' => order_repository()->getListing($request->all(), ['updated_at', 'desc'], null, 20),
        ]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRead(Order $order)
    {
        return view('admin.order.read', [
            'order' => $order,
        ]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate(Order $order)
    {
        return view('admin.order.update', [
            'order' => $order,
        ]);
    }

    /**
     * @param Order   $order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function postUpdate(Order $order, Request $request)
    {
        $form = form($request)->withRules([
            'shipping_type'      => 'required|in:individual,group',
            'billing_first_name' => 'required|max:255',
            'billing_last_name'  => 'required|max:255',
            'billing_line1'      => 'required|max:255',
            'billing_line2'      => 'nullable|max:255',
            'billing_city'       => 'required|max:255',
            'billing_state'      => 'required|max:255',
            'billing_zip_code'   => 'required|digits:5',
        ]);

        if ($request->get('shipping_type') == 'individual') {
            $form->withRules([
                'shipping_line1'    => 'required|max:255',
                'shipping_line2'    => 'nullable|max:255',
                'shipping_city'     => 'required|max:255',
                'shipping_state'    => 'required|max:255',
                'shipping_zip_code' => 'required|digits:5',
            ]);
        }

        $form->validate();

        if ($order->shipping_type == 'individual') {
            $order->update([
                'shipping_line1'    => $request->get('shipping_line1'),
                'shipping_line2'    => $request->get('shipping_line2'),
                'shipping_city'     => $request->get('shipping_city'),
                'shipping_state'    => $request->get('shipping_state'),
                'shipping_zip_code' => $request->get('shipping_zip_code'),
            ]);
        }

        $order->update([
            'shipping_type'      => $request->get('shipping_type'),
            'billing_first_name' => $request->get('billing_first_name'),
            'billing_last_name'  => $request->get('billing_last_name'),
            'billing_line1'      => $request->get('billing_line1'),
            'billing_line2'      => $request->get('billing_line2'),
            'billing_city'       => $request->get('billing_city'),
            'billing_state'      => $request->get('billing_state'),
            'billing_zip_code'   => $request->get('billing_zip_code'),
        ]);

        success('Order Information Saved');

        return form()->route('admin::order::read', [$order->id]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCancel(Order $order)
    {
        if (! in_array($order->state, ['new', 'failed'])) {
            return form()->error('Order must be either new or failed to be cancelled')->route('admin::order::read', [$order->id]);
        }
        $order->state = 'cancelled';
        $order->save();

        success('Order Information Saved');

        return form()->route('admin::order::read', [$order->id]);
    }

    /**
     * @param Order $order
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws NotImplementedException
     */
    public function postRefund(Order $order)
    {
        if (! in_array($order->state, ['success'])) {
            return form()->error('Order must be paid to be refunded')->route('admin::order::read', [$order->id]);
        }

        try {
            billing_repository($order->billing_provider)->refundOrder($order->id);
        } catch (BillingErrorException $exception) {
            form()->error($exception->getMessage());
        }

        success('Order Refunded');

        return form()->route('admin::order::read', [$order->id]);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     * @throws NotImplementedException
     */
    public function postVoid(Order $order)
    {
        try {
            billing_repository($order->billing_provider)->voidOrder($order->id);
        } catch (BillingErrorException $exception) {
            form()->error($exception->getMessage());
        }

        success('Order Voided');

        return form()->route('admin::order::read', [$order->id]);
    }
}
