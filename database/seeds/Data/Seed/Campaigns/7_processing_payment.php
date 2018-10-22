<?php

return [
    [
        'name'               => 'Friday After Class',
        'user'               => 'customer',
        'delivery'           => '+11 days',
        'estimated_quantity' => '24-47',
        'state'              => 'processing_payment',
        'artwork'            => [
            'pocket'                  => [
                'colors'      => 2,
                'description' => '"FAC" on pocket and "Est. 2018" underneath in the font of the greek letters found in the top of the picture below (disregard rest of reference image design)',
            ],
            'back'                    => [
                'colors'      => 2,
                'description' => 'A mountain design with "Friday After Class" across it with "We Live For Fridays" underneath that. 2-3 colors can be used. Use the reference image posted in the message board below and make the mountains a darker color and remove the boat paddles. Thanks!',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 1,
                'back'                     => 3,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => false,
                'design_hours'             => '1:45',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300',
                'colors_back_list'         => '#EB6FBD,#8EDD65,#8BB8E8',
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => '12"L 14"W',
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    '1904' => [
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
            '1904' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'            => '-6 days',
            'awaiting_design'    => '-5 days',
            'awaiting_approval'  => '-4 days',
            'awaiting_quote'     => '-3 days',
            'collecting_payment' => '-4 days',
            'processing_payment' => '-12 hours',
        ],
        'internal_notes'     => [
            [
                'type'    => 'on_hold_note',
                'content' => 'The estimated price per piece comes out to {$17.74 - $23.20} for 6030 - Comfort Colors Pocket T-Shirt w/ 2 colors on back / 2 colors on pocket for 24-47 pieces. ',
            ],
        ],
        'notes'              => 'print files: url',
        'quotes'             => [
            '1904' => [
                'low'   => 20.00,
                'high'  => 25.00,
                'final' => 24.85,
            ],
        ],
        'orders'             => [
            [
                'user'    => null,
                'entries' => [
                    ['product' => '1904', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                ],
                'created' => '-1 hour',
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
                    ['product' => '1904', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                    ['product' => '1904', 'color' => 'Green', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
            ],
            [
                'user'    => 'customer2',
                'entries' => [
                    ['product' => '1904', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                    ['product' => '1904', 'color' => 'Green', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-2 hour',
                'state'   => 'authorized',
            ],
            [
                'user'    => null,
                'entries' => [
                    ['product' => '1904', 'color' => 'Green', 'size' => 'S', 'quantity' => 1],
                    ['product' => '1904', 'color' => 'Green', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
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
                    ['product' => '1904', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                ],
                'created' => '-1 hour',
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
                    ['product' => '1904', 'color' => 'Green', 'size' => 'XL', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized_failed',
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
                    ['product' => '1904', 'color' => 'Green', 'size' => 'M', 'quantity' => 2],
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
        'close_date'         => '-2 hours',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-5 days',
                'text'    => 'Hey Matt
Thanks for placing a design request and welcome to Greek House!
We see that this is your first order and want to make sure your experience is perfect. Are you available for a quick call?
You can schedule a time using the following link: https://calendly.com/greekhouse/review
If you would rather chat here, can you let us know if you have a budget or price per piece you\'re looking for?
Happy to make this work for your chapter! Once we hear back, we\'ll get you a design back within 24 hours.
Best,
Greek House ',
            ],
            [
                'user'    => 'customer',
                'created' => '-3 days',
                'file'    => 'Campaigns/Images/rgb.svg',
            ],
            [
                'user'    => null,
                'created' => '-3 days',
                'text'    => 'Designer Ian has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Can we try this design that I have attached on the back with "Friday After Class" on top and "We Live For Fridays" on the bottom? ',
                'file'    => 'Campaigns/Images/layers.svg',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'I do like the color scheme though. maybe do that second design in the same colors?',
            ],
            [
                'user'    => 'support',
                'created' => '-2 days',
                'text'    => 'Hey Matt! Did you need any other changes made to the design? ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Matt has approved the design for Friday After Class',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Hey Matt, here is the payment link to share with members to make payment:
https://greekhouse.local/store/Friday-After-Class-15
If you wish to pay by check, chapter credit card, or your Group billing system please give us your sizes here on the message board and we\'ll process it accordingly.
Best,
Greek House',
            ],
        ],
    ],
];
