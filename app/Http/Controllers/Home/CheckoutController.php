<?php

namespace App\Http\Controllers\Home;

use App\Events\Order\Authorized;
use App\Events\Order\ChargedManual;
use App\Exceptions\BillingErrorException;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use Illuminate\Http\Request;
use Psy\Exception\RuntimeException;

class CheckoutController extends Controller
{
    public function getDetails($description, Request $request)
    {
        $id = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }
        if ($campaign->state != 'collecting_payment') {
            Logger::logNotice('#Campaign is #NotCollectingPayment #Checkout');

            return form()->error('The campaign you are looking for is not collecting payments at the moment.')->route('home::index');
        }
        if ($request->has('copy')) {
            $id = $request->get('copy');
            if (! is_numeric($id)) {
                return form()->route('checkout::details', [product_to_description($campaign->id, $campaign->name)]);
            }
            $order = order_repository()->find($id);
            if (! $order) {
                return form()->route('checkout::details', [product_to_description($campaign->id, $campaign->name)]);
            }
            $sizeList = [];
            $quantityList = [];
            foreach ($order->entries as $entry) {
                $productSize = product_size_repository()->findByProductIdAndShort($campaign->products->first()->id, $entry->size->short);
                if ($productSize == null) {
                    return form()->route('checkout::details', [product_to_description($campaign->id, $campaign->name)]);
                }
                $sizeList[] = $productSize->id;
                $quantityList[] = $entry->quantity;
            }
            \Session::flash('checkout-size', $sizeList);
            \Session::flash('checkout-quantity', $quantityList);
            \Session::put('checkout-form-data', [
                'shipping_type'           => $order->shipping_type,
                'shipping_line1'          => $order->shipping_line1,
                'shipping_line2'          => $order->shipping_line2,
                'shipping_city'           => $order->shipping_city,
                'shipping_state'          => $order->shipping_state,
                'shipping_zip_code'       => $order->shipping_zip_code,
                'contact_first_name'      => $order->contact_first_name,
                'contact_last_name'       => $order->contact_last_name,
                'contact_email'           => $order->contact_email,
                'contact_phone'           => $order->contact_phone,
                'billing_line1'           => $order->billing_line1,
                'billing_line2'           => $order->billing_line2,
                'billing_city'            => $order->billing_city,
                'billing_state'           => $order->billing_state,
                'billing_zip_code'        => $order->billing_zip_code,
                'contact_school'          => $order->contact_school ?? $campaign->contact_school ?? '',
                'contact_chapter'         => $order->contact_chapter ?? $campaign->contact_chapter ?? '',
                'contact_graduation_year' => $order->contact_graduation_year ?? $campaign->contact_graduation_year ?? '',
            ]);
            if ($order->payment_type == 'group') {
                return form()->route('checkout::details', ['description' => product_to_description($campaign->id, $campaign->name), 'group' => '']);
            } else {
                return form()->route('checkout::details', [product_to_description($campaign->id, $campaign->name)]);
            }
        }
        $closeDate = new \DateTime($campaign->close_date);
        $now = new \DateTime(date('Y-m-d H:i:s'));
        $difference = $closeDate->diff($now);

        return view('checkout.details', [
            'campaign'     => $campaign,
            'days'         => $difference->days,
            'hours'        => $difference->h,
            'minutes'      => $difference->i,
            'seconds'      => $difference->s,
            'sizeList'     => \Session::has('checkout-size') ? \Session::get('checkout-size') : [],
            'quantityList' => \Session::has('checkout-quantity') ? \Session::get('checkout-quantity') : [],
        ]);
    }

    public function postDetails($description, Request $request)
    {
        $id = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }
        if ($campaign->state != 'collecting_payment') {
            Logger::logNotice('#Campaign is #NotCollectingPayment #Checkout');

            return form()->error('The campaign you are looking for is not collecting payments at the moment.')->route('home::index');
        }
        $validator = \Validator::make($request->all(), [
            'quantity' => 'required|array',
            'size'     => 'required|array',
        ], [
            'quantity.required' => 'You must add at least one product to the cart to continue',
            'quantity.array'    => 'Quantity is in the wrong format',
            'size.required'     => 'You must add at least one product to the cart to continue',
            'size.array'        => 'Size is in the wrong format',
        ]);
        if ($validator->fails()) {
            \Session::flash('checkout-size', $request->get('size'));
            \Session::flash('checkout-quantity', $request->get('quantity'));

            return form()->error($validator->errors())->back();
        }
        if (count($request->get('quantity')) != count($request->get('size'))) {
            return form()->error('Quantity and Size count do not match')->back();
        }
        foreach ($request->get('size') as $size) {
            if (! is_numeric($size)) {
                \Session::flash('checkout-size', $request->get('size'));
                \Session::flash('checkout-quantity', $request->get('quantity'));

                return form()->error('Invalid Size')->back();
            }
        }
        foreach ($request->get('quantity') as $quantity) {
            if ($quantity !== '' && (! is_numeric($quantity) || $quantity < 0)) {
                \Session::flash('checkout-size', $request->get('size'));
                \Session::flash('checkout-quantity', $request->get('quantity'));

                return form()->error('Invalid Quantity')->back();
            }
        }
        $sizeList = [];
        for ($i = 0; $i < count($request->get('size')); $i++) {
            $productSize = product_size_repository()->find($request->get('size')[$i]);
            if ($productSize == null || $productSize->product_id != $campaign->products->first()->id) {
                return form()->error('Invalid Product Size')->back();
            }
            if (! array_key_exists($productSize->size->short, $sizeList)) {
                $sizeList[$productSize->size->short] = [
                    'size_id'  => $productSize->garment_size_id,
                    'short'    => $productSize->size->short,
                    'quantity' => 0,
                    'price'    => $campaign->quote_high + extra_size_charge($productSize->size->short),
                    'total'    => 0,
                ];
            }
            $sizeList[$productSize->size->short]['quantity'] += is_numeric($request->get('quantity')[$i]) ? $request->get('quantity')[$i] : 0;
            $sizeList[$productSize->size->short]['total'] = $sizeList[$productSize->size->short]['quantity'] * $sizeList[$productSize->size->short]['price'];
        }
        foreach ($sizeList as $short => $size) {
            if ($size['quantity'] <= 0) {
                unset($sizeList[$short]);
            }
        }
        if (count($sizeList) == 0) {
            \Session::flash('checkout-size', $request->get('size'));
            \Session::flash('checkout-quantity', $request->get('quantity'));

            return form()->error('You must add at least one product to the cart to continue')->back();
        }

        $quantity = 0;
        $subtotal = 0;
        $subtotalWithTax = 0;
        foreach ($sizeList as $size) {
            $quantity += $size['quantity'];
            $entrySubtotal = round($size['price'] * 1.07, 2) * $size['quantity'];
            $subtotal += $size['total'];
            $subtotalWithTax += $entrySubtotal;
        }
        $total = $subtotalWithTax;
        $tax = $total * 0.07;

        $order = order_repository()->make();
        $order->campaign_id = $campaign->id;
        $order->product_id = $campaign->products->first()->id;
        $order->color_id = $campaign->products->first()->pivot->color_id;
        $order->payment_type = $request->exists('group') ? 'group' : 'individual';
        $order->shipping_type = 'group';
        $order->user_id = \Auth::user() ? \Auth::user()->id : null;
        $order->quantity = $quantity;
        $order->subtotal = $subtotal;
        $order->shipping = 0;
        $order->tax = $tax;
        $order->total = $total;
        $order->contact_school = $campaign->contact_school;
        $order->contact_chapter = $campaign->contact_chapter;

        if (\Session::has('checkout-form-data')) {
            $data = \Session::get('checkout-form-data');
            $order->shipping_type = $data['shipping_type'];
            $order->shipping_line1 = $data['shipping_line1'];
            $order->shipping_line2 = $data['shipping_line2'];
            $order->shipping_city = $data['shipping_city'];
            $order->shipping_state = $data['shipping_state'];
            $order->shipping_zip_code = $data['shipping_zip_code'];
            $order->contact_first_name = $data['contact_first_name'];
            $order->contact_last_name = $data['contact_last_name'];
            $order->contact_email = $data['contact_email'];
            $order->contact_phone = $data['contact_phone'];
            $order->billing_line1 = $data['billing_line1'];
            $order->billing_line2 = $data['billing_line2'];
            $order->billing_city = $data['billing_city'];
            $order->billing_state = $data['billing_state'];
            $order->billing_zip_code = $data['billing_zip_code'];
            $order->contact_school = $data['contact_school'];
            $order->contact_chapter = $data['contact_chapter'];
            $order->contact_graduation_year = $data['contact_graduation_year'];
            \Session::forget('checkout-form-data');
        } elseif (\Auth::user()) {
            if (\Auth::user()->address) {
                if ($order->shipping_type == 'individual') {
                    $order->shipping_line1 = \Auth::user()->address->line1;
                    $order->shipping_line2 = \Auth::user()->address->line2;
                    $order->shipping_city = \Auth::user()->address->city;
                    $order->shipping_state = \Auth::user()->address->state;
                    $order->shipping_zip_code = \Auth::user()->address->zip_code;
                }
                $order->billing_line1 = \Auth::user()->address->line1;
                $order->billing_line2 = \Auth::user()->address->line2;
                $order->billing_city = \Auth::user()->address->city;
                $order->billing_state = \Auth::user()->address->state;
                $order->billing_zip_code = \Auth::user()->address->zip_code;
            }
            $order->contact_first_name = \Auth::user()->first_name;
            $order->contact_last_name = \Auth::user()->last_name;
            $order->contact_email = \Auth::user()->email;
            $order->contact_phone = \Auth::user()->phone;
            $order->contact_graduation_year = \Auth::user()->graduation_year;
        }

        if (! $campaign->shipping_group && $order->shipping_type == 'group') {
            $order->shipping_type = 'individual';
        }
        if (! $campaign->shipping_individual && $order->shipping_type == 'group') {
            $order->shipping_type = 'group';
        }
        if (! $campaign->shipping_individual && ! $campaign->shipping_group) {
            return form()->error('Campaign does not allow group or individual shipping')->back();
        }

        if ($order->shipping_type != 'group') {
            $order->shipping = 7 + 2 * ($order->quantity - 1);
            $order->total = $order->subtotal + $order->shipping + $order->tax;
        }
        $order->save();

        foreach ($sizeList as $size) {
            $orderEntry = order_entry_repository()->make();
            $orderEntry->order_id = $order->id;
            $orderEntry->subtotal = $size['total'];
            $orderEntry->price = $size['price'];
            $orderEntry->quantity = $size['quantity'];
            $orderEntry->garment_size_id = $size['size_id'];
            $orderEntry->save();
        }

        return form()->route('checkout::checkout', [product_to_description($campaign->id, $campaign->name), $order->id]);
    }

    public function getCheckout($description, $id)
    {
        $campaignId = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($campaignId);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }
        if ($campaign->state != 'collecting_payment') {
            Logger::logNotice('#Campaign is #NotCollectingPayment #Checkout');

            return form()->error('The campaign you are looking for is not collecting payments at the moment.')->route('home::index');
        }
        $order = order_repository()->find($id);

        return view('checkout.checkout', [
            'campaign'            => $campaign,
            'order'               => $order,
            'model'               => array_merge($order->toArray(), [
                'payment_method'       => $order->billing_provider == 'test' ? 'test' : ($order->billing_provider == 'manual' ? 'manual' : 'card'),
                'manual_payment_price' => $campaign->quote_high,
            ]),
            'productColorImage' => product_color_repository()->find($campaign->products->first()->pivot->color_id)->image,
            'checkoutManual'      => \Auth::user() && \Auth::user()->isType(['admin', 'support']),
            'checkoutTest'        => \Auth::user() && \Auth::user()->isType(['admin', 'support']) && config('greekhouse.billing.allow_test'),
        ]);
    }

    public function ajaxSaveInformation($id, Request $request)
    {
        $order = order_repository()->find($id);
        if ($order->state != 'new') {
            abort(403, 'This order has already been handled.');
        }
        $order->disableEvents();
        $order->shipping_type = $request->get('shipping_type');
        if ($request->get('shipping_type') == 'group') {
            $order->shipping_line1 = $order->campaign->address_line1;
            $order->shipping_line2 = $order->campaign->address_line2;
            $order->shipping_city = $order->campaign->address_city;
            $order->shipping_state = $order->campaign->address_state;
            $order->shipping_zip_code = $order->campaign->address_zip_code;
        } else {
            $order->shipping_line1 = $request->get('shipping_line1');
            $order->shipping_line2 = $request->get('shipping_line2');
            $order->shipping_city = $request->get('shipping_city');
            $order->shipping_state = $request->get('shipping_state');
            $order->shipping_zip_code = $request->get('shipping_zip_code');
        }
        $order->contact_first_name = $request->get('contact_first_name');
        $order->contact_last_name = $request->get('contact_last_name');
        $order->contact_email = $request->get('contact_email');
        $order->contact_phone = $request->get('contact_phone');
        $order->contact_school = $request->get('contact_school');
        $order->contact_chapter = $request->get('contact_chapter');
        $order->contact_graduation_year = $request->get('contact_graduation_year');
        if ($request->get('shipping_type') == 'individual' && $request->get('billing_same_as_shipping')) {
            $order->billing_line1 = $request->get('shipping_line1');
            $order->billing_line2 = $request->get('shipping_line2');
            $order->billing_city = $request->get('shipping_city');
            $order->billing_state = $request->get('shipping_state');
            $order->billing_zip_code = $request->get('shipping_zip_code');
        } else {
            $order->billing_line1 = $request->get('billing_line1');
            $order->billing_line2 = $request->get('billing_line2');
            $order->billing_city = $request->get('billing_city');
            $order->billing_state = $request->get('billing_state');
            $order->billing_zip_code = $request->get('billing_zip_code');
        }
        if ($request->get('payment_method') == 'manual' && \Auth::user() && \Auth::user()->isType(['admin', 'support'])) {
            $order->billing_provider = 'manual';
        } elseif ($request->get('payment_method') == 'test' && \Auth::user() && \Auth::user()->isType(['admin', 'support']) && config('greekhouse.billing.allow_test')) {
            $order->billing_provider = 'test';
        } else {
            $order->billing_provider = 'AUTHORIZE';
        }
        $shipping = 0;
        if ($order->shipping_type != 'group') {
            $shipping += 7 + (2 * ($order->quantity - 1));
        }
        $order->total = $order->total - $order->shipping + $shipping;
        $order->shipping = $shipping;
        $order->receive_marketing = $request->has('receive_emails');
        $order->save();

        return 'ok';
    }

    public function ajaxValidateInformation($id, Request $request)
    {
        $order = order_repository()->find($id);
        if ($order->state != 'new') {
            abort(403, 'This order has already been handled.');
        }
        $data = $order->toArray();
        $errors = [];
        if ($data['shipping_type'] == 'individual') {
            $validator = \Validator::make($data, [
                'shipping_line1'    => 'required',
                'shipping_line2'    => '',
                'shipping_city'     => 'required',
                'shipping_state'    => 'required',
                'shipping_zip_code' => 'required|digits:5',
            ]);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        }
        $validator = \Validator::make($data, [
            'contact_first_name' => 'required|max:255',
            'contact_last_name'  => 'required|max:255',
            'contact_email'      => 'required|email',
            'contact_phone'      => 'required|max:255',
            'billing_line1'      => 'required',
            'billing_line2'      => '',
            'billing_city'       => 'required',
            'billing_state'      => 'required',
            'billing_zip_code'   => 'required|digits:5',
        ]);
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }
        $contactPhone = get_phone_digits($data['contact_phone']);
        $validator = \Validator::make(['contact_phone' => $contactPhone], [
            'contact_phone' => 'digits:10',
        ], ['contact_phone.digits' => 'Contact Phone needs 10 digits']);
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }
        if ($data['billing_provider'] == 'manual') {
            if (! (\Auth::user() && \Auth::user()->isType(['admin', 'support']))) {
                $errors = array_merge($errors, ['payment_type' => 'invalid Payment Type']);
            }
            $validator = \Validator::make($request->all(), [
                'manual_payment_price' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        } elseif ($data['billing_provider'] == 'test') {
            if (! (\Auth::user() && \Auth::user()->isType(['admin', 'support']) && config('greekhouse.billing.allow_test'))) {
                $errors = array_merge($errors, ['payment_method' => 'Invalid Payment Method']);
            }
        } elseif ($data['billing_provider'] != 'AUTHORIZE') {
            $errors = array_merge($errors, ['payment_method' => 'Invalid Payment Method']);
        }
        if (! empty($errors)) {
            return json_encode(['success' => false, 'errors' => $errors]);
        } else {
            $timestamp = time();

            return json_encode([
                'success'      => true,
                'fp_timestamp' => $timestamp,
                'fp_sequence'  => $id,
                'fp_hash'      => hash_hmac('md5', config('greekhouse.billing.providers.authorize.login').'^'.$order->id.'^'.$timestamp.'^'.number_format($order->total, 2, '.', '').'^USD', config('greekhouse.billing.providers.authorize.key')),
            ]);
        }
    }

    public function postCheckoutManual($description, $id, Request $request)
    {
        $campaignId = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($campaignId);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }
        if ($campaign->state != 'collecting_payment') {
            Logger::logNotice('#Campaign is #NotCollectingPayment #Checkout');

            return form()->error('The campaign you are looking for is not collecting payments at the moment.')->route('home::index');
        }
        $order = order_repository()->find($id);
        if (! (\Auth::user() && \Auth::user()->isType(['admin', 'support']))) {
            Logger::logNotice('Access Denied');

            return form()->error('Access Denied')->back();
        }
        if ($order->billing_provider != 'manual') {
            Logger::logNotice('#Campaign has #WrongProvider Manual #Checkout');

            return form()->error('Campaign has wrong payment method.')->back();
        }
        try {
            $response = json_decode($this->ajaxValidateInformation($id, $request), true);
            if ($response['success'] == false) {
                return form()->error($response['errors'])->back();
            }
        } catch (\Exception $ex) {
            return form()->error($ex->getMessage())->back();
        }

        $subtotal = 0;
        $total = 0;
        foreach ($order->entries as $entry) {
            $priceWithTax = $request->get('manual_payment_price') + extra_size_charge($entry->size->short);
            $priceWithoutTax = $priceWithTax / 1.07;
            $total += $priceWithTax * $entry->quantity;
            $entry->price = $priceWithoutTax;
            $entry->subtotal = $entry->price * $entry->quantity;
            $entry->save();
            $subtotal += $entry->subtotal;
        }
        $order->subtotal = $subtotal;
        $order->tax = $total - $subtotal;
        $order->total = $total + $order->shipping;
        $order->billing_customer_id = 0;
        $order->billing_card_id = 0;
        $order->billing_charge_id = 0;
        $order->billing_provider = 'manual';
        $order->state = 'success';
        $order->save();

        Logger::logDebug('#Order '.$order->id.' #ManualPayment #'.$order->state.' #Checkout');

        event(new ChargedManual($order->id));

        $order = order_repository()->find($order->id);
        $campaign->contact_first_name = $order->contact_first_name;
        $campaign->contact_last_name = $order->contact_last_name;
        $campaign->contact_phone = $order->contact_phone;
        $campaign->contact_email = $order->contact_email;
        $campaign->address_line1 = $order->shipping_line1;
        $campaign->address_line2 = $order->shipping_line2;
        $campaign->address_city = $order->shipping_city;
        $campaign->address_state = $order->shipping_state;
        $campaign->address_zip_code = $order->shipping_zip_code;
        $campaign->address_country = $order->shipping_country;
        $campaign->save();

        if ($campaign->hasMetEstimatedQuantity()) {
            $campaign->closePayment();
            $campaign->notificationPaymentClosed();
        }

        return form()->route('checkout::thank_you', [product_to_description($campaign->id, $campaign->name), $id]);
    }

    public function postCheckoutTest($description, $id)
    {
        $campaignId = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($campaignId);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }
        if ($campaign->state != 'collecting_payment') {
            Logger::logNotice('#Campaign is #NotCollectingPayment #Checkout');

            return form()->error('The campaign you are looking for is not collecting payments at the moment.')->route('home::index');
        }
        $order = order_repository()->find($id);
        if (! (\Auth::user() && \Auth::user()->isType(['admin', 'support']) && config('greekhouse.billing.allow_test'))) {
            Logger::logNotice('Access Denied');

            return form()->error('Access Denied')->back();
        }
        if ($order->billing_provider != 'test') {
            Logger::logNotice('#Campaign has #WrongProvider Test #Checkout');

            return form()->error('Campaign has wrong payment method.')->back();
        }
        try {
            $response = json_decode($this->ajaxValidateInformation($id, new Request()), true);
            if ($response['success'] == false) {
                return form()->error($response['errors'])->back();
            }
        } catch (\Exception $ex) {
            return form()->error($ex->getMessage())->back();
        }
        $order->billing_provider = 'test';
        $order->state = 'success';
        $order->save();

        Logger::logDebug('#Order '.$order->id.' #TestPayment #'.$order->state.' #Checkout');

        return form()->route('checkout::thank_you', [product_to_description($campaign->id, $campaign->name), $id]);
    }

    public function postCheckoutAuthorize($description, $id, Request $request)
    {
        $campaignId = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($campaignId);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }
        if ($campaign->state != 'collecting_payment') {
            Logger::logNotice('#Campaign is #NotCollectingPayment #Checkout');

            return form()->error('The campaign you are looking for is not collecting payments at the moment.')->route('home::index');
        }
        $order = order_repository()->find($id);

        try {
            billing_repository()->authorizeOrder($order, $request->get('code'), $request->get('description'));

            event(new Authorized($order->id));

            return form()->url(route('checkout::thank_you', [product_to_description($campaign->id, $campaign->name), $order->id]));
        } catch (BillingErrorException $ex) {
            return form()->error($ex->getMessage())->back();
        } catch (RuntimeException $ex) {
            return form()->error($ex->getMessage())->back();
        }
    }

    public function getThankYou($description, $id)
    {
        $campaignId = get_product_id_from_description($description);
        $campaign = campaign_repository()->find($campaignId);
        if ($campaign == null) {
            Logger::logWarning('#Campaign does #NotExists #Checkout');

            return form()->error('The campaign you are looking for does not exist.')->route('home::index');
        }

        $order = order_repository()->find($id);

        return view('checkout.thank_you', [
            'typeCaption' => ($order->payment_type == 'group') ? 'Group' : 'Individual',
            'order'       => $order,
        ]);
    }
}
