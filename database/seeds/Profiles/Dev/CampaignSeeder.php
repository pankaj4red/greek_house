<?php

class CampaignSeeder extends BaseSeeder
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
        $campaigns = include(database_path('seeds/Data/Seed/campaigns.php'));

        foreach ($campaigns as $campaign) {
            $artworkRequestData = [];
            if (isset($campaign['artwork']['front'])) {
                $artworkRequestData['print_front'] = true;
                $artworkRequestData['print_front_colors'] = $campaign['artwork']['front']['colors'];
                $artworkRequestData['print_front_description'] = $campaign['artwork']['front']['description'];
            }
            if (isset($campaign['artwork']['pocket'])) {
                $artworkRequestData['print_pocket'] = true;
                $artworkRequestData['print_pocket_colors'] = $campaign['artwork']['pocket']['colors'];
                $artworkRequestData['print_pocket_description'] = $campaign['artwork']['pocket']['description'];
            }
            if (isset($campaign['artwork']['back'])) {
                $artworkRequestData['print_back'] = true;
                $artworkRequestData['print_back_colors'] = $campaign['artwork']['back']['colors'];
                $artworkRequestData['print_back_description'] = $campaign['artwork']['back']['description'];
            }
            if (isset($campaign['artwork']['sleeve'])) {
                $artworkRequestData['print_sleeve'] = true;
                $artworkRequestData['print_sleeve_colors'] = $campaign['artwork']['sleeve']['colors'];
                $artworkRequestData['print_sleeve_description'] = $campaign['artwork']['sleeve']['description'];
                $artworkRequestData['print_sleeve_preferred'] = $campaign['artwork']['sleeve']['preferred'];
            }
            if (isset($campaign['artwork']['design'])) {
                $artworkRequestData['designer_colors_front'] = $campaign['artwork']['design']['front'];
                $artworkRequestData['designer_colors_back'] = $campaign['artwork']['design']['back'];
                $artworkRequestData['designer_colors_sleeve_left'] = $campaign['artwork']['design']['left_sleeve'];
                $artworkRequestData['designer_colors_sleeve_right'] = $campaign['artwork']['design']['right_sleeve'];
                $artworkRequestData['designer_black_shirt'] = $campaign['artwork']['design']['black_shirt'];
                $artworkRequestData['design_minutes'] = to_minutes($campaign['artwork']['design']['design_hours']);
                $artworkRequestData['speciality_inks'] = $campaign['artwork']['design']['speciality_inks'] ? 'yes' : 'no';
                $artworkRequestData['embellishment_names'] = $campaign['artwork']['design']['embellishment_names'] ? 'yes' : 'no';
                $artworkRequestData['embellishment_numbers'] = $campaign['artwork']['design']['embellishment_numbers'] ? 'yes' : 'no';

                $artworkRequestData['designer_colors_front_list'] = $campaign['artwork']['design']['colors_front_list'];
                $artworkRequestData['designer_colors_back_list'] = $campaign['artwork']['design']['colors_back_list'];
                $artworkRequestData['designer_colors_sleeve_left_list'] = $campaign['artwork']['design']['colors_sleeve_left_list'];
                $artworkRequestData['designer_colors_sleeve_right_list'] = $campaign['artwork']['design']['colors_sleeve_right_list'];

                if (isset($campaign['artwork']['design']['revisions'])) {
                    if ($campaign['artwork']['design']['revisions']['revision_count']) {
                        $artworkRequestData['revision_count'] = $campaign['artwork']['design']['revisions']['revision_count'];
                    }
                    if ($campaign['artwork']['design']['revisions']['revision_text']) {
                        $artworkRequestData['revision_text'] = $campaign['artwork']['design']['revisions']['revision_text'];
                    }
                }
                if (isset($campaign['artwork']['times'])) {
                    if (isset($campaign['artwork']['times']['designer_action_required'])) {
                        $artworkRequestData['designer_action_required_at'] = \Carbon\Carbon::parse($campaign['artwork']['times']['designer_action_required'])->format('Y-m-d H:i:s');
                    }
                    if (isset($campaign['artwork']['times']['designer_assigned'])) {
                        $artworkRequestData['designer_assigned_at'] = \Carbon\Carbon::parse($campaign['artwork']['times']['designer_assigned'])->format('Y-m-d H:i:s');
                    }
                }
                if (isset($campaign['artwork']['designer'])) {
                    $artworkRequestData['designer_id'] = $this->getUserFromCache($campaign['artwork']['designer'])->id;
                }
                if (isset($campaign['artwork']['hourly_rate'])) {
                    $artworkRequestData['hourly_rate'] = $campaign['artwork']['hourly_rate'];
                }
            }

            $artworkRequestModel = factory(\App\Models\ArtworkRequest::class)->create(array_merge([
                'design_style_preference' => $campaign['artwork']['design_style_preference'],
                'design_type'             => $campaign['artwork']['design_type'],
            ], $artworkRequestData));

            $images = [];
            if (isset($campaign['images'])) {
                foreach ($campaign['images'] as $image) {
                    $images[] = $this->getImageIdFromCache($image, $addImages);
                }
            }

            if (isset($campaign['artwork']['design']['proofs'])) {
                foreach ($campaign['artwork']['design']['proofs'] as $productStyleNumber => $colors) {
                    foreach ($colors as $colorName => $colorImages) {
                        $productColorId = $this->getProductColorFromCache($productStyleNumber, $colorName)->id;
                        foreach ($colorImages as $area => $image) {
                            if ($image == null) {
                                continue;
                            }
                            artwork_request_file_repository()->create([
                                'artwork_request_id' => $artworkRequestModel->id,
                                'product_color_id'   => $productColorId,
                                'file_id'            => $this->getImageIdFromCache($image, $addImages),
                                'type'               => $area,
                                'sort'               => 0,
                            ]);
                        }
                    }
                }
            }

            $printFiles = [];
            if (isset($campaign['artwork']['design']['print_files'])) {
                foreach ($campaign['artwork']['design']['print_files'] as $image) {
                    $printFiles[] = $this->getImageIdFromCache($image, $addImages);
                }
            }

            $index = 0;
            foreach ($images as $image) {
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $artworkRequestModel->id,
                    'file_id'            => $image,
                    'type'               => 'image',
                    'sort'               => $index++,
                ]);
            }

            $index = 0;
            foreach ($printFiles as $image) {
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $artworkRequestModel->id,
                    'file_id'            => $image,
                    'type'               => 'print_file',
                    'sort'               => $index++,
                ]);
            }

            $times = [];
            if (isset($campaign['times'])) {
                if (isset($campaign['times']['created'])) {
                    $times['created_at'] = \Carbon\Carbon::parse($campaign['times']['created']);
                }
                if (isset($campaign['times']['on_hold'])) {
                    $times['on_hold_at'] = \Carbon\Carbon::parse($campaign['times']['on_hold']);
                }
                if (isset($campaign['times']['assigned_decorator_date'])) {
                    $times['assigned_decorator_date'] = \Carbon\Carbon::parse($campaign['times']['assigned_decorator_date']);
                }
            }

            $model = factory(\App\Models\Campaign::class)->create(array_merge([
                'name'               => $campaign['name'],
                'user_id'            => $this->getUserFromCache($campaign['user'])->id,
                'flexible'           => $campaign['delivery'] == 'flexible' ? 'yes' : 'no',
                'date'               => $campaign['delivery'] == 'flexible' ? null : ($campaign['delivery'] == 'rush' ? \Carbon\Carbon::parse('+12 days')->format('Y-m-d H:i:s') : \Carbon\Carbon::parse($campaign['delivery'])->format('Y-m-d H:i:s')),
                'rush'               => $campaign['delivery'] == 'rush' ? true : ($campaign['delivery'] < '+12' ? true : false),
                'state'              => $campaign['state'],
                'on_hold_reason'     => isset($campaign['on_hold_reason']) ? $campaign['on_hold_reason'] : null,
                'on_hold_category'   => isset($campaign['on_hold_category']) ? $campaign['on_hold_category'] : null,
                'on_hold_rule'       => isset($campaign['on_hold_rule']) ? $campaign['on_hold_rule'] : null,
                'on_hold_actor'      => isset($campaign['on_hold_actor']) ? $this->getUserFromCache($campaign['on_hold_actor'])->id : null,
                'artwork_request_id' => $artworkRequestModel->id,
                'notes'              => isset($campaign['notes']) ? $campaign['notes'] : null,
                'close_date'         => isset($campaign['close_date']) ? \Carbon\Carbon::parse($campaign['close_date']) : null,
                'tracking_code'      => isset($campaign['tracking_code']) ? $campaign['tracking_code'] : null,
            ], $times));

            $productColorsIds = [];
            foreach ($campaign['products'] as $productStyleNumber => $colorList) {
                foreach ($colorList as $color) {
                    $productColorsIds[] = $this->getProductColorFromCache($productStyleNumber, $color)->id;
                }
            }

            $model->product_colors()->sync($productColorsIds);

            if (isset($campaign['quotes'])) {
                foreach ($campaign['quotes'] as $productStyleNumber => $quote) {
                    campaign_quote_repository()->create([
                        'campaign_id' => $model->id,
                        'product_id'  => $this->getProductFromCache($productStyleNumber)->id,
                        'quote_low'   => isset($quote['low']) ? $quote['low'] : null,
                        'quote_high'  => isset($quote['high']) ? $quote['high'] : null,
                        'quote_final' => isset($quote['final']) ? $quote['final'] : null,
                    ]);
                }
            }

            if (isset($campaign['internal_notes'])) {
                foreach ($campaign['internal_notes'] as $internalNote) {
                    campaign_note_repository()->create([
                        'campaign_id' => $model->id,
                        'type'        => $internalNote['type'],
                        'content'     => $internalNote['content'],
                    ]);
                }
            }

            if (isset($campaign['comments'])) {
                foreach ($campaign['comments'] as $comment) {
                    comment_repository()->create([
                        'campaign_id' => $model->id,
                        'user_id'     => isset($comment['user']) ? $this->getUserFromCache($comment['user'])->id : null,
                        'body'        => isset($comment['text']) ? $comment['text'] : null,
                        'channel'     => 'customer',
                        'file_id'     => isset($comment['file']) ? $this->getImageIdFromCache($comment['file'], $addImages) : null,
                    ]);
                }
            }

            $globalOrderMetadata = [
                'colors' => [],
            ];

            if (isset($campaign['orders'])) {
                foreach ($campaign['orders'] as $order) {
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
                            'shipping_line1'     => $order['address']['line1'],
                            'shipping_line2'     => $order['address']['line2'],
                            'shipping_city'      => $order['address']['city'],
                            'shipping_state'     => $order['address']['state'],
                            'shipping_zip_code'  => $order['address']['zip_code'],
                            'shipping_country'   => 'usa',
                            'billing_first_name' => $order['contact']['first_name'],
                            'billing_last_name'  => $order['contact']['last_name'],
                            'billing_line1'      => $order['address']['line1'],
                            'billing_line2'      => $order['address']['line2'],
                            'billing_city'       => $order['address']['city'],
                            'billing_state'      => $order['address']['state'],
                            'billing_zip_code'   => $order['address']['zip_code'],
                            'billing_country'    => 'usa',
                        ];
                    }

                    $subtotal = 0;
                    $quantity = 0;
                    foreach ($order['entries'] as $entry) {
                        $campaignQuote = $model->quotes->where('product_id', $this->getProductFromCache($entry['product'])->id)->first();
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
                        'campaign_id'      => $model->id,
                        'state'            => $order['state'],
                        'quantity'         => $quantity,
                        'subtotal'         => $subtotal,
                        'shipping'         => 0,
                        'tax'              => $tax,
                        'total'            => $total,
                        'billing_provider' => 'test',
                        'created_at'       => \Carbon\Carbon::parse($order['created'])->format('Y-m-d H:i:s'),
                    ], $userInformation));

                    foreach ($order['entries'] as $entry) {
                        $campaignQuote = $model->quotes->where('product_id', $this->getProductFromCache($entry['product'])->id)->first();
                        $price = extra_size_charge($entry['size']) + $campaignQuote->quote_final ? $campaignQuote->quote_final : $campaignQuote->quote_high;
                        if (! $price) {
                            dd([$entry, $campaign]);
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

            if (isset($campaign['fulfillment'])) {
                $supplier = supplier_repository()->findByName($campaign['fulfillment']['supplier']);

                foreach ($globalOrderMetadata['colors'] as $colorEntry) {
                    $campaignSupply = campaign_supply_repository()->create([
                        'campaign_id'      => $model->id,
                        'supplier_id'      => $supplier->id,
                        'product_color_id' => $colorEntry['product_color_id'],
                        'eta'              => \Carbon\Carbon::parse($campaign['fulfillment']['eta'])->format('d/m'),
                        'quantity'         => $colorEntry['quantity'],
                        'ship_from'        => $campaign['fulfillment']['ship_from'],
                        'total'            => $colorEntry['total'],
                        'state'            => 'new',
                    ]);

                    foreach ($colorEntry['sizes'] as $size) {
                        campaign_supply_entry_repository()->create([
                            'campaign_supply_id' => $campaignSupply->id,
                            'garment_size_id'    => $size['garment_size_id'],
                            'quantity'           => $size['quantity'],
                            'price'              => $size['price'],
                            'subtotal'           => $size['price'] * $size['quantity'],
                        ]);
                    }
                }

                $model->update([
                    'garment_arrival_date'       => \Carbon\Carbon::parse($campaign['fulfillment']['garment_arrival_date'])->format('Y-m-d'),
                    'printing_date'              => \Carbon\Carbon::parse($campaign['fulfillment']['printing_date'])->format('Y-m-d'),
                    'days_in_transit'            => $campaign['fulfillment']['days_in_transit'],
                    'decorator_pocket'           => isset($campaign['artwork']['pocket']) && $campaign['artwork']['pocket'] ? 'yes' : 'no',
                    'shipping_option'            => $campaign['fulfillment']['shipping_option'],
                    'fulfillment_valid'          => isset($campaign['fulfillment']['valid']) ? $campaign['fulfillment']['valid'] : true,
                    'fulfillment_invalid_reason' => isset($campaign['fulfillment']['invalid_reason']) ? $campaign['fulfillment']['invalid_reason'] : null,
                    'fulfillment_invalid_text'   => isset($campaign['fulfillment']['invalid_text']) ? $campaign['fulfillment']['invalid_text'] : null,
                    'decorator_id'               => isset($campaign['fulfillment']['decorator']) ? $this->getUserFromCache($campaign['fulfillment']['decorator'])->id : null,
                ]);
            }

            $design = design_repository()->createFromCampaign($model);
            if (isset($campaign['design'])) {
                $design->update([
                    'trending' => isset($campaign['design']['trending']) ? $campaign['design']['trending'] : false,
                    'status'   => isset($campaign['design']['trending']) ? $campaign['design']['status'] : false,
                ]);

                if (isset($campaign['design']['images'])) {
                    $index = 0;
                    foreach ($campaign['design']['images'] as $image) {
                        design_file_repository()->create([
                            'design_id' => $design->id,
                            'type'      => 'image',
                            'file_id'   => $this->getImageIdFromCache($image['image'], $addImages),
                            'enabled'   => $image['enabled'],
                            'sort'      => $index++,
                        ]);
                    }
                }

                if (isset($campaign['tags'])) {
                    foreach ($campaign['tags'] as $group => $tags) {
                        foreach ($tags as $tag) {
                            design_tag_repository()->createTagOnGroup($design->id, $group, $tag);
                        }
                    }
                }
            }
        }
    }
}