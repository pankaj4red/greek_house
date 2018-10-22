<?php

class CartSeeder extends BaseSeeder
{
    private $imageCache = [];

    private $userCache = [];

    private $productCache = [];

    private $productColorCache = [];

    private function getImageIdFromCache($image, $addImages = false)
    {
        if (! isset($this->imageCache[$image])) {
            $this->imageCache[$image] = $addImages ? $this->createFileFromSVG($image)->id : 1;
        }

        return $this->imageCache[$image];
    }

    private function getUserFromCache($username)
    {
        if (! isset($this->userCache[$username])) {
            $this->userCache[$username] = user_repository()->findByEmailOrUsername($username);
        }

        return $this->userCache[$username];
    }

    private function getProductFromCache($productStyleNumber)
    {
        if (! isset($this->productCache[$productStyleNumber])) {
            $this->productCache[$productStyleNumber] = product_repository()->findByStyleNumber($productStyleNumber);
        }

        return $this->productCache[$productStyleNumber];
    }

    private function getProductColorFromCache($productStyleNumber, $colorName)
    {
        if (! isset($this->productColorCache[$productStyleNumber.'_'.$colorName])) {
            $this->productColorCache[$productStyleNumber.'_'.$colorName] = product_color_repository()->findByProductStyleNumberAndColorName($productStyleNumber, $colorName);
        }

        return $this->productColorCache[$productStyleNumber.'_'.$colorName];
    }

    /**
     * Run the database seeds.
     *
     * @param bool $addImages
     * @return void
     */
    public function run($addImages = false)
    {
        $carts = include(database_path('seeds/Data/Seed/carts.php'));

        foreach ($carts as $cart) {
            $model = cart_repository()->create([
                'billing_line1'    => isset($cart['billing']['line1']) ? $cart['billing']['line1'] : null,
                'billing_line2'    => isset($cart['billing']['line2']) ? $cart['billing']['line2'] : null,
                'billing_city'     => isset($cart['billing']['city']) ? $cart['billing']['city'] : null,
                'billing_state'    => isset($cart['billing']['state']) ? $cart['billing']['state'] : null,
                'billing_zip_code' => isset($cart['billing']['zip_code']) ? $cart['billing']['zip_code'] : null,

                'contact_first_name' => isset($cart['contact']['first_name']) ? $cart['contact']['first_name'] : null,
                'contact_last_name'  => isset($cart['contact']['last_name']) ? $cart['contact']['last_name'] : null,
                'contact_email'      => isset($cart['contact']['email']) ? $cart['contact']['email'] : null,
                'contact_phone'      => isset($cart['contact']['phone']) ? $cart['contact']['phone'] : null,

                'state'         => $cart['state'],
                'shipping_type' => $cart['shipping_type'],
            ]);

            if (isset($cart['orders'])) {
                foreach ($cart['orders'] as $order) {
                    $campaignModel = campaign_repository()->findByName($order['campaign']);
                    $orderMetadata = [
                        'quantity' => 0,
                        'total'    => 0,
                        'entries'  => [],
                    ];

                    if ($order['user']) {
                        $user = $this->getUserFromCache($order['user']);

                        $userInformation = [
                            'contact_first_name' => $user->first_name,
                            'contact_last_name'  => $user->last_name,
                            'contact_email'      => $user->email,
                            'contact_phone'      => $user->phone,
                            'contact_school'     => $user->school_text,
                            'contact_chapter'    => $user->chapter_text,
                            'shipping_line1'     => $user->addresses->first()->line1,
                            'shipping_line2'     => $user->addresses->first()->line2,
                            'shipping_city'      => $user->addresses->first()->city,
                            'shipping_state'     => $user->addresses->first()->state,
                            'shipping_zip_code'  => $user->addresses->first()->zip_code,
                            'shipping_country'   => $user->addresses->first()->country,
                            'billing_first_name' => $user->first_name,
                            'billing_last_name'  => $user->last_name,
                            'billing_line1'      => $user->addresses->first()->line1,
                            'billing_line2'      => $user->addresses->first()->line2,
                            'billing_city'       => $user->addresses->first()->city,
                            'billing_state'      => $user->addresses->first()->state,
                            'billing_zip_code'   => $user->addresses->first()->zip_code,
                            'billing_country'    => $user->addresses->first()->country,
                        ];
                    } else {
                        $userInformation = [
                            'contact_first_name' => $order['contact']['first_name'],
                            'contact_last_name'  => $order['contact']['last_name'],
                            'contact_email'      => $order['contact']['email'],
                            'contact_phone'      => $order['contact']['phone'],
                            'contact_school'     => $order['contact']['school'],
                            'contact_chapter'    => $order['contact']['chapter'],
                            'shipping_line1'     => isset($order['address']['line1']) ? $order['address']['line1'] : null,
                            'shipping_line2'     => isset($order['address']['line2']) ? $order['address']['line2'] : null,
                            'shipping_city'      => isset($order['address']['city']) ? $order['address']['city'] : null,
                            'shipping_state'     => isset($order['address']['line1']) ? $order['address']['state'] : null,
                            'shipping_zip_code'  => isset($order['address']['line1']) ? $order['address']['line1'] : null,
                            'shipping_country'   => 'usa',
                            'billing_first_name' => $order['contact']['first_name'],
                            'billing_last_name'  => $order['contact']['last_name'],
                            'billing_line1'      => isset($order['address']['line1']) ? $order['address']['line1'] : null,
                            'billing_line2'      => isset($order['address']['line2']) ? $order['address']['line2'] : null,
                            'billing_city'       => isset($order['address']['city']) ? $order['address']['city'] : null,
                            'billing_state'      => isset($order['address']['state']) ? $order['address']['state'] : null,
                            'billing_zip_code'   => isset($order['address']['zip_code']) ? $order['address']['zip_code'] : null,
                            'billing_country'    => 'usa',
                        ];
                    }

                    $subtotal = 0;
                    $quantity = 0;
                    foreach ($order['entries'] as $entry) {
                        $campaignQuote = $campaignModel->quotes->where('product_id', $this->getProductFromCache($entry['product'])->id)->first();
                        $price = extra_size_charge($entry['size']) + $campaignQuote->quote_final ? $campaignQuote->quote_final : $campaignQuote->quote_high;
                        $quantity += $entry['quantity'];
                        $subtotal += $price * $entry['quantity'];

                        // Order Metadata
                        if (! isset($orderMetadata['entries'][$entry['product'].'_'.$entry['color'].'_'.$entry['size']])) {
                            $orderMetadata['entries'][$entry['product'].'_'.$entry['color'].'_'.$entry['size']] = [
                                'product_color_id' => $this->getProductColorFromCache($entry['product'], $entry['color'])->id,
                                'garment_size_id'  => garment_size_by_short($entry['size'])->id,
                                'price'            => $price,
                                'quantity'         => 0,
                            ];
                        }
                        $orderMetadata['entries'][$entry['product'].'_'.$entry['color'].'_'.$entry['size']]['quantity'] += $entry['quantity'];
                        $orderMetadata['quantity'] += $entry['quantity'];
                        $orderMetadata['total'] += $price * $entry['quantity'];

                        // Global Order Metadata
                        if (! isset($globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']])) {
                            $globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']] = [
                                'product_color_id' => $this->getProductColorFromCache($entry['product'], $entry['color'])->id,
                                'price'            => $price,
                                'quantity'         => 0,
                                'sizes'            => [],
                                'total'            => 0,
                            ];
                        }
                        if (! isset($globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']]['sizes'][$entry['size']])) {
                            $globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']]['sizes'][$entry['size']] = [
                                'garment_size_id' => garment_size_by_short($entry['size'])->id,
                                'quantity'        => 0,
                                'price'           => $price,
                            ];
                        }

                        $globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']]['quantity'] += $entry['quantity'];
                        $globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']]['total'] += $price * $entry['quantity'];
                        $globalOrderMetadata['colors'][$entry['product'].'_'.$entry['color']]['sizes'][$entry['size']]['quantity'] += $entry['quantity'];
                    }

                    $tax = $subtotal * 0.07;
                    $total = $subtotal + $tax;

                    $orderMetadata['quantity'] += $quantity;

                    $orderModel = order_repository()->create(array_merge([
                        'cart_id'     => $model->id,
                        'campaign_id' => $campaignModel->id,
                        'state'       => $order['state'],
                        'quantity'    => $quantity,
                        'subtotal'    => $subtotal,
                        'shipping'    => 0,
                        'tax'         => $tax,
                        'total'       => $total,
                        'created_at'  => \Carbon\Carbon::parse($order['created'])->format('Y-m-d H:i:s'),
                    ], $userInformation));

                    foreach ($order['entries'] as $entry) {
                        $campaignQuote = $campaignModel->quotes->where('product_id', $this->getProductFromCache($entry['product'])->id)->first();
                        $price = extra_size_charge($entry['size']) + $campaignQuote->quote_final ? $campaignQuote->quote_final : $campaignQuote->quote_high;
                        if (! $price) {
                            dd([$entry, $cart]);
                        }
                        order_entry_repository()->create([
                            'order_id'         => $orderModel->id,
                            'product_color_id' => $orderMetadata['entries'][$entry['product'].'_'.$entry['color'].'_'.$entry['size']]['product_color_id'],
                            'garment_size_id'  => $orderMetadata['entries'][$entry['product'].'_'.$entry['color'].'_'.$entry['size']]['garment_size_id'],
                            'quantity'         => $entry['quantity'],
                            'price'            => $price,
                            'subtotal'         => $price * $entry['quantity'],
                        ]);
                    }
                }
            }
        }
    }
}