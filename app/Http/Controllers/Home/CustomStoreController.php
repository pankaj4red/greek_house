<?php

namespace App\Http\Controllers\Home;

use App\Events\Order\ChargedManual;
use App\Exceptions\BillingErrorException;
use App\Exceptions\HubSpotException;
use App\Exceptions\NotImplementedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\CustomStore\CheckoutDetailsRequest;
use App\Logging\Logger;
use App\Models\Campaign;
use App\Models\Cart;
use App\Models\ProductColor;
use App\Models\User;
use App\Services\HubSpot;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Session;

class CustomStoreController extends Controller
{
    /**
     * @return string|null
     */
    private function getBraintreeTokenFromSession()
    {
        if (Auth::user()) {
            return Auth::user()->billing_customer_id;
        }

        return Session::get('braintree_token');
    }

    /**
     * @param bool $onlyUnprocessed
     * @return Cart
     */
    private function getCartFromSession($onlyUnprocessed = false)
    {
        $cart = null;
        if (Session::has('cart_id')) {
            $cart = cart_repository()->find(Session::get('cart_id'));
        }

        if (! $cart) {
            $cart = cart_repository()->create();
        }

        if ($onlyUnprocessed && $cart->hasProcessedOrders()) {
            $cart = $cart->createCartWithUnprocessedOrders();
        }

        if (Auth::user() && ! $cart->contact_first_name) {
            $cart->update([
                'contact_first_name'      => Auth::user() ? Auth::user()->first_name : null,
                'contact_last_name'       => Auth::user() ? Auth::user()->last_name : null,
                'contact_email'           => Auth::user() ? Auth::user()->email : null,
                'contact_phone'           => Auth::user() ? Auth::user()->phone : null,
                'billing_line1'           => Auth::user() && Auth::user()->address ? Auth::user()->address->line1 : null,
                'billing_line2'           => Auth::user() && Auth::user()->address ? Auth::user()->address->line2 : null,
                'billing_city'            => Auth::user() && Auth::user()->address ? Auth::user()->address->city : null,
                'billing_state'           => Auth::user() && Auth::user()->address ? Auth::user()->address->state : null,
                'billing_zip_code'        => Auth::user() && Auth::user()->address ? Auth::user()->address->zip_code : null,
                'shipping_line1'          => Auth::user() && Auth::user()->address ? Auth::user()->address->line1 : null,
                'shipping_line2'          => Auth::user() && Auth::user()->address ? Auth::user()->address->line2 : null,
                'shipping_city'           => Auth::user() && Auth::user()->address ? Auth::user()->address->city : null,
                'shipping_state'          => Auth::user() && Auth::user()->address ? Auth::user()->address->state : null,
                'shipping_zip_code'       => Auth::user() && Auth::user()->address ? Auth::user()->address->zip_code : null,
                'contact_school'          => Auth::user() ? Auth::user()->school : null,
                'contact_chapter'         => Auth::user() ? Auth::user()->chapter : null,
                'contact_graduation_year' => Auth::user() ? Auth::user()->graduation_year : null,
            ]);
        }

        Session::put('cart_id', $cart->id);

        return $cart;
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCampaigns(User $user)
    {
        return view('v3.home.custom_store.campaigns', [
            'campaigns'   => campaign_repository()->getCampaignsInUserStore($user->id, 0, 20),
            'user'        => $user,
            'chapterName' => $user->chapter ? $user->chapter : 'Your Store',
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCart()
    {
        return view('v3.home.custom_store.cart', [
            'cart' => $this->getCartFromSession(true),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postCart(Request $request)
    {
        $form = form($request)->withRules([
            'quantity'   => 'required|array|same_size:entry',
            'entry'      => 'required|array',
            'quantity.*' => 'integer|min:1',
            'entry.*'    => 'integer|min:1',
        ]);

        $form->validate();

        $cart = $this->getCartFromSession(true);
        if ($cart->orders->count() == 0) {
            return form()->error('You must add at least one product to the cart to continue')->back();
        }

        // Update Quantities
        foreach ($cart->orders as $order) {
            foreach ($order->entries as $entry) {
                foreach ($request->get('entry') as $index => $entryId) {
                    if ($entryId == $entry->id) {
                        $entry->update([
                            'quantity' => $request->get('quantity')[$index],
                        ]);
                    }
                }
            }
            $order->updateMetadata();
        }

        return form()->route('custom_store::checkout');
    }

    /**
     * @param Campaign          $campaign
     * @param ProductColor|null $productColor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetails(Campaign $campaign, ProductColor $productColor = null)
    {
        $countdownTimer = Carbon::parse($campaign->close_date)->diff(Carbon::now());

        return view('v3.home.custom_store.details', [
            'campaign'             => $campaign,
            'campaigns'            => campaign_repository()->getCampaignsInUserStore($campaign->user_id, 0, 5),
            'productColorToSelect' => $productColor,
            'days'                 => $countdownTimer->days,
            'hours'                => $countdownTimer->h,
            'minutes'              => $countdownTimer->i,
            'seconds'              => $countdownTimer->s,
        ]);
    }

    /**
     * @param Campaign               $campaign
     * @param CheckoutDetailsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDetails(Campaign $campaign, CheckoutDetailsRequest $request)
    {
        $cart = $cart ?? $this->getCartFromSession();

        // Build information regarding sizes and totals
        $entries = [];

        foreach ($request->get('color') as $index => $colorId) {
            $productSize = product_size_repository()->find($request->get('size')[$index]);
            $productColor = product_color_repository()->find($colorId);
            $entry = (object) [
                'color_id' => $productColor->id,
                'size_id'  => $productSize->garment_size_id,
                'quantity' => $request->get('quantity')[$index],
                'price'    => round(($campaign->quotes->where('product_id', $productColor->product_id)->first()->quote_high + extra_size_charge($productSize->size->short)) * 1.07, 2),
            ];
            $entries[] = $entry;
        }

        $cart->addProductColors($campaign, $entries);

        return form()->route('custom_store::cart');
    }

    /**
     * @param Cart|null $cart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCheckout(Cart $cart = null)
    {
        try {
            if (! $cart) {
                $cart = $this->getCartFromSession(true);

                return redirect()->route('custom_store::checkout', [$cart->id]);
            }

            $cart = $cart ?? $this->getCartFromSession();
            if ($cart->orders->count() == 0) {
                return form()->error('Can\'t checkout empty cart')->route('custom_store::cart');
            }

            $clientToken = null;
            $customerId = $this->getBraintreeTokenFromSession();

            // Attempt to create client token from existing customer entry
            if ($customerId) {
                $clientToken = billing_repository()->getClientToken($customerId);
            }

            // Create new customer entry and client token
            if (! $clientToken) {
                $clientToken = billing_repository()->getClientToken();
            }

            if (! $clientToken) {
                return form()->error('Unable to create vault')->route('custom_store::cart');
            }

            if ($clientToken) {
                if (Auth::user() && ! Auth::user()->billing_customer_id) {
                    Auth::user()->update([
                        'billing_customer_id' => $customerId,
                    ]);
                }

                $cart->update([
                    'billing_provider'    => 'braintree',
                    'billing_customer_id' => $customerId,
                ]);
            }

            return view('v3.home.custom_store.checkout', [
                'cart'           => $cart,
                'checkoutManual' => Auth::user() && Auth::user()->isType(['admin', 'support']),
                'clientToken'    => $clientToken,
            ]);
        } catch (NotImplementedException $ex) {
            Logger::logError($ex->getMessage(), ['exception' => $ex]);

            return form()->error('Functionality not currently available')->back();
        }
    }

    /**
     * @param Request   $request
     * @param Cart|null $cart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postCheckout(Request $request, Cart $cart = null)
    {
        try {
            $cart = $cart ?? $this->getCartFromSession();
            if ($cart->isEmpty()) {
                return form()->error('Can\'t checkout empty cart')->route('custom_store::cart');
            }

            if ($cart->hasProcessedOrders()) {
                return form()->error('Can\'t checkout cart with orders twice. Checked out orders were removed from cart.')->route('custom_store::cart');
            }

            if ($request->get('payment_method') == 'manual') {
                return $this->postCheckoutManual($request, $cart);
            }

            if ($cart->billing_provider != 'braintree') {
                return form()->error('Invalid Provider.')->route('custom_store::cart');
            }

            $paymentMethod = $request->get('payment_method') ?? $cart->payment_method;
            $paymentNonce = null;
            if ($paymentMethod == 'card') {
                $paymentNonce = $request->get('payment_nonce');
            }

            $this->updateCartData($cart, $request, ['payment_nonce' => $paymentNonce ?? $cart->payment_nonce]);

            $paymentMethod = null;
            try {
                $customerId = $this->getBraintreeTokenFromSession();
                if (! $customerId) {
                    $customerId = billing_repository()->createCustomer($cart->contact_first_name, $cart->contact_last_name, $cart->contact_email, $cart->contact_phone);
                    $cart->update([
                        'billing_customer_id' => $customerId,
                    ]);
                    if (Auth::user() && ! Auth::user()->billing_customer_id) {
                        Auth::user()->update([
                            'billing_customer_id' => $customerId,
                        ]);
                    }
                }

                if (! $paymentNonce) {
                    throw new BillingErrorException('A credit card is required');
                }

                $paymentMethod = billing_repository()->addPaymentMethod($cart->billing_customer_id, $paymentNonce);
            } catch (BillingErrorException $exception) {
                return form()->error($exception->getMessage())->back();
            }

            $this->updateOrderData($cart, $request, ['billing_provider' => 'braintree']);

            // Deal with authorization
            foreach ($cart->orders as $order) {
                billing_repository()->authorizeOrder($cart->billing_customer_id, $paymentMethod, $order->id);
            }

            // Integrate with hubspot
            if (config('services.hubspot.api.enabled')) {
                try {
                    $hubspot = new HubSpot();
                    $hubspot->submitForm(config('services.hubspot.api.forms.checkout'), [
                        'firstname'                 => $cart->contact_first_name,
                        'lastname'                  => $cart->contact_last_name,
                        'email'                     => $cart->contact_email,
                        'phone'                     => $cart->contact_phone,
                        'college_university_c_1__c' => $cart->contact_school,
                        'chapter__c'                => $cart->contact_chapter,
                        'graduation_year'           => $cart->contact_graduation_year,
                        'sales_rep_customer__c'     => $cart->user_id ? user_type_to_salesforce_user_type($cart->user) : 'Individual Customer',
                        'hs_context'                => json_encode([
                            'hutk'      => Session::get('gclid'),
                            'ipAddress' => $request->ip(),
                            'pageUrl'   => $request->fullUrl(),
                            'pageName'  => 'Checkout',
                        ]),
                    ]);
                } catch (HubSpotException $ex) {
                    Logger::logError('#Checkout HUBSPOT: '.$ex->getMessage(), ['exception' => $ex]);
                }
            }

            Session::forget('cart_id');

            return form()->route('custom_store::thank_you', [$cart->id]);
        } catch (NotImplementedException $ex) {
            Logger::logError($ex->getMessage(), ['exception' => $ex]);

            return form()->error('Functionality not currently available')->back();
        }
    }

    /**
     * @param Cart    $cart
     * @param Request $request
     * @param array   $extra
     */
    private function updateCartData(Cart $cart, Request $request, $extra = [])
    {
        $cart->update(array_merge([
            'contact_first_name'      => $request->get('contact_first_name'),
            'contact_last_name'       => $request->get('contact_last_name'),
            'contact_email'           => $request->get('contact_email'),
            'contact_phone'           => $request->get('contact_phone'),
            'contact_school'          => $request->get('contact_school'),
            'contact_chapter'         => $request->get('contact_chapter'),
            'contact_graduation_year' => $request->get('contact_graduation_year'),
            'shipping_line1'          => $request->get('shipping_line1'),
            'shipping_line2'          => $request->get('shipping_line2'),
            'shipping_city'           => $request->get('shipping_city'),
            'shipping_state'          => $request->get('shipping_state'),
            'shipping_zip_code'       => $request->get('shipping_zip_code'),
            'allow_marketing'         => $request->get('allow_marketing') ? true : false,
            'payment_method'          => $request->get('payment_method'),
        ], $extra));
    }

    /**
     * @param Cart    $cart
     * @param Request $request
     * @param array   $extra
     */
    private function updateOrderData(Cart $cart, Request $request, $extra = [])
    {
        form()->validateData([
            'contact_first_name'      => $cart->contact_first_name,
            'contact_last_name'       => $cart->contact_last_name,
            'contact_email'           => $cart->contact_email,
            'contact_phone'           => $cart->contact_phone,
            'contact_school'          => $cart->contact_school,
            'contact_chapter'         => $cart->contact_chapter,
            'contact_graduation_year' => $cart->contact_graduation_year,
            'payment_method'          => $cart->payment_method,
        ], [
            'contact_first_name'      => 'required|max:255',
            'contact_last_name'       => 'required|max:255',
            'contact_email'           => 'required|email|max:255',
            'contact_phone'           => 'required|phone',
            'contact_school'          => 'required|max:255',
            'contact_chapter'         => 'required|max:255',
            'contact_graduation_year' => 'required|max:255',
            'shipping_line1'          => 'max:255',
            'shipping_line2'          => 'max:255',
            'shipping_city'           => 'max:255',
            'shipping_state'          => 'max:255',
            'shipping_zip_code'       => 'digits:5',
            'payment_method'          => 'required|in:card,manual',
        ]);

        // Update Orders
        foreach ($cart->orders as $order) {
            $shippingInformation = [];
            if ($request->get('shipping_type_'.$order->id) || ($order->campaign->shipping_individual && ! $order->campaign->shipping_group)) {
                if ($request->get('shipping_type_'.$order->id) == 'individual' || ($order->campaign->shipping_individual && ! $order->campaign->shipping_group)) {
                    $shippingInformation = [
                        'shipping_type'     => 'individual',
                        'shipping_line1'    => $cart->shipping_line1,
                        'shipping_line2'    => $cart->shipping_line2,
                        'shipping_city'     => $cart->shipping_city,
                        'shipping_state'    => $cart->shipping_state,
                        'shipping_zip_code' => $cart->shipping_zip_code,
                    ];
                }
            }

            $order->update(array_merge([
                'contact_first_name'      => $cart->contact_first_name,
                'contact_last_name'       => $cart->contact_last_name,
                'contact_email'           => $cart->contact_email,
                'contact_phone'           => $cart->contact_phone,
                'contact_school'          => $cart->contact_school,
                'contact_chapter'         => $cart->contact_chapter,
                'contact_graduation_year' => $cart->contact_graduation_year,
                'billing_line1'           => $cart->billing_line1,
                'billing_line2'           => $cart->billing_line2,
                'billing_city'            => $cart->billing_city,
                'billing_state'           => $cart->billing_state,
                'billing_zip_code'        => $cart->billing_zip_code,
            ], $shippingInformation, $extra));

            $order->updateMetadata();
        }
    }

    /**
     * @param Cart $cart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getThankYou(Cart $cart)
    {
        return view('v3.home.custom_store.thank_you', [
            'cart' => $cart,
        ]);
    }

    /**
     * @param Request   $request
     * @param Cart|null $card
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postCheckoutManual(Request $request, Cart $card = null)
    {
        $cart = $cart ?? $this->getCartFromSession();
        if ($cart->isEmpty()) {
            return form()->error('Can\'t checkout empty cart')->route('custom_store::cart');
        }

        if ($cart->hasProcessedOrders()) {
            return form()->error('Can\'t checkout cart with orders twice. Checked out orders were removed from cart.')->route('custom_store::cart');
        }

        if ($request->get('payment_method') != 'manual') {
            return $this->postCheckout($request, $cart);
        }

        $this->updateCartData($cart, $request);
        $this->updateOrderData($cart, $request, ['billing_provider' => 'manual']);

        // Deal with authorization
        foreach ($cart->orders as $order) {
            foreach ($order->entries as $entry) {
                if ($request->get('manual_payment_price_'.$entry->id)) {
                    $price = str_replace('$', '', $request->get('manual_payment_price_'.$entry->id));
                    $entry->update([
                        'price'    => $price,
                        'subtotal' => $price * $entry->quantity,
                    ]);
                }
            }
            $order->updateMetadata();
            $order->update([
                'state' => 'success',
            ]);

            Logger::logDebug('#Order '.$order->id.' #ManualPayment #'.$order->state.' #Checkout');
            event(new ChargedManual($order->id));
        }

        Session::forget('cart_id');

        return form()->route('custom_store::thank_you', [$cart->id]);
    }

    /**
     * @param Request $request
     * @param Cart    $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAjaxDeleteItem(Request $request, Cart $cart)
    {
        $cart = $cart ?? $this->getCartFromSession();
        if ($cart->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
            ]);
        }

        if (! $request->get('id')) {
            return response()->json([
                'success' => false,
                'message' => 'Order Entry Id is needed',
            ]);
        }

        $found = false;
        foreach ($cart->orders as $order) {
            foreach ($order->entries as $entry) {
                if ($entry->id == $request->get('id')) {
                    $found = true;
                    break;
                }
            }
        }
        if ($found == false) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown Order',
            ]);
        }

        try {
            $cart->removeOrderEntry($request->get('id'));
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order Removed',
        ]);
    }
}
