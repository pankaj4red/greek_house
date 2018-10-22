<?php

return [
    [
        'name'               => 'Alpha Phi Formal Shirt',
        'user'               => 'customer',
        'delivery'           => '+8 days',
        'estimated_quantity' => '72-143',
        'state'              => 'fulfillment_ready',
        'artwork'            => [
            'front'                   => [
                'colors'      => 1,
                'description' => '1. change Alpha Xi Delta to Tri Sigma
2. Bid Day 2018 under Tri Sigma',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 4,
                'back'                     => 0,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => false,
                'design_hours'             => '1:35',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300,#EB6FBD,#8EDD65,#8BB8E8',
                'colors_back_list'         => null,
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => null,
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    '2408' => [
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
                    '3633' => [
                        'Green' => [
                            'proof_front'    => 'Campaigns/Proofs/sweater.svg',
                            'proof_back'     => 'Campaigns/Proofs/sweater-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                        'Brown' => [
                            'proof_front'    => 'Campaigns/Proofs/polo.svg',
                            'proof_back'     => 'Campaigns/Proofs/polo-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                    ],
                ],
                'print_files'              => [
                    'Campaigns/Images/layers.svg',
                    'Campaigns/Images/rgb.svg',
                ],
            ],
            'designer'                => 'designer',
            'times'                   => [
                'designer_assigned' => '-3 days',
            ],
            'hourly_rate'             => 30.00,
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '2408' => ['Green', 'Slate', 'Brown'],
            '3633' => ['Green', 'Brown'],
        ],
        'times'              => [
            'created'            => '-7 days',
            'awaiting_design'    => '-6 days',
            'awaiting_approval'  => '-5 days',
            'awaiting_quote'     => '-4 days',
            'collecting_payment' => '-3 days',
            'processing_payment' => '-1 days',
            'fulfillment_ready'  => '-6 hours',
        ],
        'notes'              => 'FULFILLMENT: MAKE SURE RINGER IS BLACK IF THAT\'S HER FINAL CHOICE

PRINT FILES
url',
        'quotes'             => [
            '2408' => [
                'low'   => 14.00,
                'high'  => 19.50,
                'final' => 15.00,
            ],
            '3633' => [
                'low'   => 28.00,
                'high'  => 28.00,
                'final' => 28.00,
            ],
        ],
        'orders'             => [
            [
                'user'    => null,
                'entries' => [
                    ['product' => '2408', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                ],
                'created' => '-1 day',
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
                'user'    => 'customer',
                'entries' => [
                    ['product' => '2408', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                    ['product' => '2408', 'color' => 'Slate', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-1 day',
                'state'   => 'success',
            ],
            [
                'user'    => 'customer2',
                'entries' => [
                    ['product' => '2408', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                    ['product' => '2408', 'color' => 'Green', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-2 hour',
                'state'   => 'success',
            ],
            [
                'user'    => null,
                'entries' => [
                    ['product' => '2408', 'color' => 'Green', 'size' => 'S', 'quantity' => 1],
                    ['product' => '2408', 'color' => 'Slate', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-1 day',
                'state'   => 'success',
                'contact' => [
                    'first_name' => 'Jordan',
                    'last_name'  => 'Marshall',
                    'email'      => 'jordan_marshall@gmail.com',
                    'phone'      => '202-555-0104',
                    'school'     => 'UCLA',
                    'chapter'    => 'Alpha Phi Beta Delta',
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
                    ['product' => '2408', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                ],
                'created' => '-1 day',
                'state'   => 'success',
                'contact' => [
                    'first_name' => 'Dani',
                    'last_name'  => 'Decesare',
                    'email'      => 'dani_decesare@gmail.com',
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
            [
                'user'    => null,
                'entries' => [
                    ['product' => '2408', 'color' => 'Green', 'size' => 'XL', 'quantity' => 1],
                ],
                'created' => '-1 day',
                'state'   => 'success',
                'contact' => [
                    'first_name' => 'Christine',
                    'last_name'  => 'Bolsens',
                    'email'      => 'christine_bolsens@gmail.com',
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
            [
                'user'    => null,
                'entries' => [
                    ['product' => '3633', 'color' => 'Brown', 'size' => 'M', 'quantity' => 2],
                ],
                'created' => '-1 day',
                'state'   => 'success',
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
        'close_date'         => '-2 hours',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-5 days',
                'text'    => 'hello i was wondering when i will receiving the proofs for this shirt? thank you! ',
            ],
            [
                'user'    => 'support',
                'created' => '-3 days',
                'text'    => 'Hi Danielle! Will this be the final/last proof?',
            ],
            [
                'user'    => 'customer',
                'created' => '-3 days',
                'text'    => 'yes this will more than likely be the shirt i will go with ',
            ],
            [
                'user'    => 'support',
                'created' => '-2 days',
                'text'    => 'Sounds good! Do you have a budget for this?

We’ll have it back later this weekend. ',
            ],
            [
                'user'    => 'support',
                'created' => '-2 days',
                'text'    => 'Hey Danielle,

The WOMEN\'S BABY RIB SHORT SLEEVE RINGER TEE is not available in white/black so "white/navy" was used in the proof instead (https://www.bellacanvas.com/product/1007/Womens-Baby-Rib-Short-Sleeve-Ringer-Tee.html).

Does that work?

If you want, we can change them to a WOMEN\'S JERSEY SHORT SLEEVE RINGER TEE : https://www.bellacanvas.com/product/6050/Womens-Jersey-Short-Sleeve-Ringer-Tee.html

Let us know what you think,.

Thanks
Greek House ',
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
