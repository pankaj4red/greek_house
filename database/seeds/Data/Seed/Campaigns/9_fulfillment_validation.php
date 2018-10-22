<?php

return [
    [
        'name'               => 'PNM Bag',
        'user'               => 'customer',
        'delivery'           => '+6 days',
        'estimated_quantity' => '144+',
        'state'              => 'fulfillment_validation',
        'artwork'            => [
            'front'                   => [
                'colors'      => 2,
                'description' => 'Same logo',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 2,
                'back'                     => 0,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => false,
                'design_hours'             => '0:25',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300,#EB6FBD',
                'colors_back_list'         => null,
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => null,
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    '7006' => [
                        'Green' => [
                            'proof_front'    => 'Campaigns/Proofs/shirt.svg',
                            'proof_back'     => 'Campaigns/Proofs/shirt-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                        'Slate' => [
                            'proof_front'    => 'Campaigns/Proofs/coat.svg',
                            'proof_back'     => 'Campaigns/Proofs/coat-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                        'Brown' => [
                            'proof_front'    => 'Campaigns/Proofs/jacket.svg',
                            'proof_back'     => 'Campaigns/Proofs/jacket-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                    ],
                ],
                'print_files'              => [
                    'Campaigns/Images/layers.svg',
                ],
            ],
            'designer'                => 'designer',
            'times'                   => [
                'designer_assigned' => '-8 days',
            ],
            'hourly_rate'             => 30.00,
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '7006' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'                 => '-9 days',
            'awaiting_design'         => '-8 days',
            'awaiting_approval'       => '-7 days',
            'awaiting_quote'          => '-6 days',
            'collecting_payment'      => '-4 days',
            'processing_payment'      => '-3 days',
            'fulfillment_ready'       => '-2 days',
            'fulfillment_validation'  => '-1 days',
            'assigned_decorator_date' => '-14 hours',
        ],
        'notes'              => 'Pricing: $2.88/piece for 650; after 40% accessory item discount, new price= $1.73/piece or $1123.20 total - Luke

PRINT FILES
url',
        'quotes'             => [
            '7006' => [
                'low'   => 13.00,
                'high'  => 25.50,
                'final' => 18.00,
            ],
        ],
        'orders'             => [
            [
                'user'    => null,
                'entries' => [
                    ['product' => '7006', 'color' => 'Green', 'size' => 'OneSize', 'quantity' => 140],
                    ['product' => '7006', 'color' => 'Brown', 'size' => 'OneSize', 'quantity' => 20],
                    ['product' => '7006', 'color' => 'Slate', 'size' => 'OneSize', 'quantity' => 265],
                ],
                'created' => '-4 day',
                'state'   => 'success',
                'contact' => [
                    'first_name' => 'Angelica',
                    'last_name'  => 'Payne',
                    'email'      => 'angelica_payne@gmail.com',
                    'phone'      => '202-555-0185',
                    'school'     => 'UCLA',
                    'chapter'    => 'Beta Delta',
                ],
                'address' => [
                    'line1'    => '714 Hilgard Ave',
                    'line2'    => null,
                    'city'     => 'Los Angeles',
                    'state'    => 'CA',
                    'zip_code' => '90024',
                ],
            ],
        ],
        'fulfillment'        => [
            'supplier'             => 'One Stop Screens',
            'garment_arrival_date' => '+1 day',
            'printing_date'        => '+2 days',
            'days_in_transit'      => '1',
            'pockets'              => false,
            'shipping_option'      => 'fedex_ground',
            'eta'                  => '+5 days',
            'ship_from'            => 'ca',
            'decorator'            => 'decorator',
        ],
        'close_date'         => '-3 days',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-5 days',
                'text'    => 'Designer Camille has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-3 days',
                'text'    => 'Clare has approved the design for PNM Bag',
            ],
            [
                'user'    => 'support',
                'created' => '-3 days',
                'text'    => 'Greek House
05/02/2018 | 04:48 pm
Hey Clare, here is the payment link to share with members to make payment:
https://greekhouse.org/store/PNM-Bag-123456789
If you wish to pay by check, chapter credit card, or your Group billing system please give us your sizes here on the message board and we\'ll process it accordingly.
Best,
Greek House
',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'just to make sure, because I cna\'t really tell, but it says "recruitment 2018" right. just sort of looks like 2013, but also I could be going crazy haha ',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Payment has been closed.',
            ],
            [
                'user'    => null,
                'created' => '-1 day',
                'text'    => 'Hey Clare
Here is the order list for you:
XXX
Your Order will arrive within 10 Business Days unless specified otherwise.
If you have any additional questions or concerns, please let us know.
Best,
Greek House',
            ],
        ],
    ],
    [
        'name'               => 'RC Water Bottle',
        'user'               => 'customer2',
        'delivery'           => 'flexible',
        'estimated_quantity' => '24-47',
        'state'              => 'fulfillment_validation',
        'artwork'            => [
            'front'                   => [
                'colors'      => 3,
                'description' => 'The logo attached',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 2,
                'back'                     => 0,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => true,
                'design_hours'             => '1:005',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300,#EB6FBD',
                'colors_back_list'         => null,
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => null,
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    '7006' => [
                        'Green' => [
                            'proof_front'    => 'Campaigns/Proofs/shirt.svg',
                            'proof_back'     => 'Campaigns/Proofs/shirt-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                        'Slate' => [
                            'proof_front'    => 'Campaigns/Proofs/coat.svg',
                            'proof_back'     => 'Campaigns/Proofs/coat-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                        'Brown' => [
                            'proof_front'    => 'Campaigns/Proofs/jacket.svg',
                            'proof_back'     => 'Campaigns/Proofs/jacket-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                    ],
                ],
                'print_files'              => [
                    'Campaigns/Images/layers.svg',
                ],
            ],
            'designer'                => 'designer2',
            'times'                   => [
                'designer_assigned' => '-9 days',
            ],
            'hourly_rate'             => 30.00,
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '7006' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'                => '-10 days',
            'awaiting_design'        => '-9 days',
            'awaiting_approval'      => '-8 days',
            'awaiting_quote'         => '-7 days',
            'collecting_payment'     => '-6 days',
            'processing_payment'     => '-2 days',
            'fulfillment_ready'      => '-2 days',
            'fulfillment_validation' => '-1 days',
        ],
        'notes'              => 'PRINT FILES
url

$546.18 TOTAL FROM MANUFACTURER',
        'quotes'             => [
            '7006' => [
                'low'   => 16.00,
                'high'  => 17.50,
                'final' => 19.00,
            ],
        ],
        'orders'             => [
            [
                'user'    => null,
                'entries' => [
                    ['product' => '7006', 'color' => 'Green', 'size' => 'OneSize', 'quantity' => 45],
                ],
                'created' => '-4 day',
                'state'   => 'success',
                'contact' => [
                    'first_name' => 'Angelica',
                    'last_name'  => 'Payne',
                    'email'      => 'angelica_payne@gmail.com',
                    'phone'      => '202-555-0185',
                    'school'     => 'UCLA',
                    'chapter'    => 'Beta Delta',
                ],
                'address' => [
                    'line1'    => '714 Hilgard Ave',
                    'line2'    => null,
                    'city'     => 'Los Angeles',
                    'state'    => 'CA',
                    'zip_code' => '90024',
                ],
            ],
            [
                'user'    => null,
                'entries' => [
                    ['product' => '7006', 'color' => 'Green', 'size' => 'OneSize', 'quantity' => 15],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
                'contact' => [
                    'first_name' => 'Natalie',
                    'last_name'  => 'LaRocca',
                    'email'      => 'natalie_larocca@gmail.com',
                    'phone'      => '202-555-0190',
                    'school'     => 'UCLA',
                    'chapter'    => 'Beta Delta',
                ],
                'address' => [
                    'line1'    => '714 Hilgard Ave',
                    'line2'    => null,
                    'city'     => 'Los Angeles',
                    'state'    => 'CA',
                    'zip_code' => '90024',
                ],
            ],
        ],
        'fulfillment'        => [
            'supplier'             => 'Staton',
            'garment_arrival_date' => '-13 hours',
            'printing_date'        => '+4 days',
            'days_in_transit'      => '2',
            'pockets'              => false,
            'shipping_option'      => 'fedex_ground',
            'eta'                  => '+3 days',
            'ship_from'            => 'CA',
            'valid'                => false,
            'invalid_reason'       => 'Artwork',
            'invalid_text'         => 'Bad artwork!',
            'decorator'            => 'decorator',
        ],
        'close_date'         => '-4 days',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-5 days',
                'text'    => 'Designer Camille has uploaded a proof!',
            ],
            [
                'user'    => 'customer',
                'created' => '-3 days',
                'text'    => 'can we make the bottom leaves yellow as well',
            ],
            [
                'user'    => 'customer',
                'created' => '-3 days',
                'text'    => 'Clare has requested a revision for RC Water Bottle
can we make the bottom leaves yellow as well',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Designer Camille has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Clare has approved the design for RC Water Bottle',
            ],
            [
                'user'    => 'support',
                'created' => '-1 day',
                'text'    => 'Hey Clare, here is the payment link to share with members to make payment:
https://greekhouse.org/store/RC-Water-Bottle-22222
If you wish to pay by check, chapter credit card, or your Group billing system please give us your sizes here on the message board and we\'ll process it accordingly.
Best,
Greek House',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Payment has been closed.',
            ],
            [
                'user'    => 'support',
                'created' => '-2 days',
                'text'    => 'Hey Clare,

We processed and posted the invoice for this order. You can also use this link to make a payment: url

The check can be made out to College Thread LLC or Greek House.

You can mail the check to:
8550 Charl Ln.Los Angeles, CA 90046

Please let us know if you have any questions or concerns.

Thanks,
Greek House
FILE',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Hey Clare
Here is the order list for you:
    shipping_file_24898.pdf
Your Order will arrive within 10 Business Days unless specified otherwise.
If you have any additional questions or concerns, please let us know.
Best,
Greek House',
            ],
        ],
    ],
];
