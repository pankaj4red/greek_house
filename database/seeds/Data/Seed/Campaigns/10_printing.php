<?php

return [
    [
        'name'               => 'Recruitment Workshop',
        'user'               => 'customer',
        'delivery'           => '+4 days',
        'estimated_quantity' => '72-143',
        'state'              => 'printing',
        'artwork'            => [
            'front'                   => [
                'colors'      => 6,
                'description' => '1. The attached picture of block letters in different colors but saying "Alpha Xi Delta" instead, preferably on two lines instead of 3
2. Underneath "Alpha Xi Delta", put "Recruitment Workshop 2018"
3. Colors matching the colors on the back',
            ],
            'back'                    => [
                'colors'      => 6,
                'description' => '1. Attached picture of the circle of different colors.
2. "Alpha Xi Delta" instead of Kappa Delta
3. Through the middle putting "Courage. Graciousness. Peace."
4. Bottom of the circle putting "Recruitment Workshop 2018"',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 6,
                'back'                     => 6,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => false,
                'design_hours'             => '2:15',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300,#EB6FBD,#8EDD65,#8BB8E8,#656635,#485CC7',
                'colors_back_list'         => '#FFA300,#EB6FBD,#8EDD65,#8BB8E8,#656635,#485CC7',
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => '12"L 14"W',
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    '3501' => [
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
            '3501' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'                => '-9 days',
            'awaiting_design'        => '-8 days',
            'awaiting_approval'      => '-7 days',
            'awaiting_quote'         => '-6 days',
            'collecting_payment'     => '-4 days',
            'processing_payment'     => '-3 days',
            'fulfillment_ready'      => '-2 days',
            'fulfillment_validation' => '-1 days',
        ],
        'notes'              => '***FULFILLMENT: MAKE THE 2XL A 3XL***

print files:
url',
        'quotes'             => [
            '3501' => [
                'low'   => 14.00,
                'high'  => 23.50,
                'final' => 19.00,
            ],
        ],
        'orders'             => [
            [
                'user'    => null,
                'entries' => [
                    ['product' => '3501', 'color' => 'Green', 'size' => 'S', 'quantity' => 8],
                    ['product' => '3501', 'color' => 'Green', 'size' => 'M', 'quantity' => 66],
                    ['product' => '3501', 'color' => 'Slate', 'size' => 'L', 'quantity' => 27],
                    ['product' => '3501', 'color' => 'Brown', 'size' => 'XL', 'quantity' => 6],
                    ['product' => '3501', 'color' => 'Brown', 'size' => '2XL', 'quantity' => 1],
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
            'supplier'             => 'Driving I',
            'garment_arrival_date' => '+2 day',
            'printing_date'        => '-13 hours',
            'days_in_transit'      => '2',
            'pockets'              => false,
            'shipping_option'      => 'fedex_ground',
            'eta'                  => '+5 days',
            'ship_from'            => 'IL',
            'decorator'            => 'decorator',
        ],
        'close_date'         => '-4 days',
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
];
