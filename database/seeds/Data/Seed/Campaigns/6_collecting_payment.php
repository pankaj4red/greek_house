<?php

return [
    [
        'name'               => 'Bid Day 2018',
        'user'               => 'customer',
        'delivery'           => '+14 days',
        'estimated_quantity' => '24-47',
        'state'              => 'collecting_payment',
        'artwork'            => [
            'back'                    => [
                'colors'      => 1,
                'description' => 'We would like the back of the shirt as similar as possible to the picture I’m attaching. If we could try the Polaroid style image with a few pops of light pink/red that would be great. We want the lettering to say “You’re the one that we want” and the scarf to say AXO. And it will be Oklahoma City University.',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 1,
                'back'                     => 4,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => false,
                'design_hours'             => '3:30',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300',
                'colors_back_list'         => '#EB6FBD,#8EDD65,#8BB8E8,#656635',
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => '12"L 14"W',
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    'G2200' => [
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
                    'B4070' => [
                        'Slate' => [
                            'proof_front'    => 'Campaigns/Proofs/sweater.svg',
                            'proof_back'     => 'Campaigns/Proofs/sweater-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                    ],
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
            'G2200' => ['Green', 'Slate', 'Brown'],
            'B4070' => ['Slate'],
        ],
        'times'              => [
            'created'            => '-4 days',
            'awaiting_design'    => '-3 days',
            'awaiting_approval'  => '-3 days',
            'awaiting_quote'     => '-2 days',
            'collecting_payment' => '-1 days',
        ],
        'quotes'             => [
            'G2200' => [
                'low'  => 20.00,
                'high' => 25.00,
            ],
            'B4070' => [
                'low'  => 28.00,
                'high' => 28.00,
            ],
        ],
        'orders'             => [],
        'close_date'         => '+18 days',
        'notes'              => 'kindly note the change in garment color - Olie

Garment changed to chambray as requested. - jen

Pricing:
$17/shirt for 85

PRINT FILES: url',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-3 days',
                'text'    => 'Hey Meghan,

Thanks for placing a design request with Greek House.

Please let us know if you have any questions or concerns!',
            ],
            [
                'user'    => null,
                'created' => '-3 days',
                'text'    => 'Designer Luke has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Hi! These look great! Can we try the shirt itself in a lighter blue color, closet to the image I attached? ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => '
Can we also add an exclamation point to you’re the one that we want? And try maybe an underlines font like the photo I sent? ',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Greek House has requested a revision for Bid Day 2018
+luke- please see above revisions. thanks ',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Designer Luke has uploaded a proof!',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'That looks much better! Is it possible for the design itself not to have the darker green?',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Could we do it black? ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Or the blue of the shirt if possible? Could we also try a slightly lighter pink for the sky? ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'I’m sorry, before you go through the trouble of making the new proof, could we also try the shirt color in chambray? ',
            ],
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Designer Luke has uploaded a proof!',
            ],
            [
                'user'    => 'customer',
                'created' => '-1 days',
                'text'    => 'Hi!
I am waiting on a response from our bid day chair, and I will let you know ASAP when we will have sizes ready! Our bid day will be August 19th, so I would like to have them delivered a week beforehand if possible! Thank you! ',
            ],
            [
                'user'    => 'support',
                'created' => '-1 days',
                'text'    => 'Hey Meghan! Sounds good, let us know when you get an update! The current delivery date is set for August 10th, so if you need it any sooner than that, let us know. We\'ll make a note on this order that you don\'t need them until then, we\'d just need to get sizes from you by the last week of July if possible :)',
            ],
        ],
    ],
    [
        'name'               => 'Alpha Phi Formal Shirt',
        'user'               => 'customer',
        'delivery'           => '+13 days',
        'estimated_quantity' => '24-47',
        'state'              => 'collecting_payment',
        'artwork'            => [
            'pocket'                  => [
                'colors'      => 2,
                'description' => '1. Have the frocket have Alpha Phi Letters in the Baylor Font and then in smaller font UCLA underneath (See photo attached)
2. Have letters on the front be in pastel peach and then UCLA underneath in white.',
            ],
            'back'                    => [
                'colors'      => 5,
                'description' => '1. Have the Design on the back be the same as the Baylor Logo (see photo attached). Replace Baylor with Los Angeles delta detla delta with Alpha Phi, 2016 with 2018, and Family Weekend with Formal (all in the same font)
    2. Have the colors of the logo be the same as the Kappa Delta photo (see photo attached). Bright pastel colors.
    3. Have the Los Angeles Block letters display a beach scene (instead of the photos used in the Baylor letters)',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
            'design'                  => [
                'front'                    => 2,
                'back'                     => 4,
                'left_sleeve'              => 0,
                'right_sleeve'             => 0,
                'black_shirt'              => false,
                'design_hours'             => '1:25',
                'speciality_inks'          => false,
                'embellishment_names'      => false,
                'embellishment_numbers'    => false,
                'colors_front_list'        => '#FFA300,#EB6FBD',
                'colors_back_list'         => '#EB6FBD,#8EDD65,#8BB8E8,#656635',
                'colors_sleeve_left_list'  => null,
                'colors_sleeve_right_list' => '',
                'dimensions_front'         => '12"L 14"W',
                'dimensions_back'          => '12"L 14"W',
                'dimensions_sleeve_left'   => null,
                'dimensions_sleeve_right'  => null,
                'proofs'                   => [
                    '3480'  => [
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
                    'G2200' => [
                        'Slate' => [
                            'proof_front'    => 'Campaigns/Proofs/sweater.svg',
                            'proof_back'     => 'Campaigns/Proofs/sweater-1.svg',
                            'proof_close_up' => null,
                            'proof_other'    => null,
                        ],
                    ],
                ],
            ],
            'designer'                => 'designer2',
            'times'                   => [
                'designer_assigned' => '-2 days',
            ],
            'hourly_rate'             => 30.00,
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '3480'  => ['Green', 'Slate', 'Brown'],
            'G2200' => ['Slate'],
        ],
        'times'              => [
            'created'            => '-5 days',
            'awaiting_design'    => '-4 days',
            'awaiting_approval'  => '-4 days',
            'awaiting_quote'     => '-3 days',
            'collecting_payment' => '-2 days',
        ],
        'quotes'             => [
            '3480'  => [
                'low'  => 20.00,
                'high' => 25.00,
            ],
            'G2200' => [
                'low'  => 28.00,
                'high' => 28.00,
            ],
        ],
        'orders'             => [
            [
                'user'    => null,
                'entries' => [
                    ['product' => '3480', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
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
                    ['product' => '3480', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                    ['product' => '3480', 'color' => 'Slate', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
            ],
            [
                'user'    => 'customer2',
                'entries' => [
                    ['product' => '3480', 'color' => 'Green', 'size' => 'M', 'quantity' => 1],
                    ['product' => '3480', 'color' => 'Green', 'size' => 'L', 'quantity' => 1],
                ],
                'created' => '-2 hour',
                'state'   => 'authorized',
            ],
            [
                'user'    => null,
                'entries' => [
                    ['product' => '3480', 'color' => 'Brown', 'size' => 'S', 'quantity' => 1],
                    ['product' => '3480', 'color' => 'Brown', 'size' => 'L', 'quantity' => 1],
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
                    ['product' => 'G2200', 'color' => 'Slate', 'size' => 'M', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
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
                    ['product' => 'G2200', 'color' => 'Slate', 'size' => 'XL', 'quantity' => 1],
                ],
                'created' => '-1 hour',
                'state'   => 'authorized',
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
                    ['product' => '3480', 'color' => 'Green', 'size' => 'M', 'quantity' => 2],
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
        'close_date'         => '+17 days',
        'notes'              => 'Use this design for the Los Angeles post card, but make sure to change the colors up to fit what Sarah is going for:
https://www.dropbox.com/sh/6iqg1kp6cxhsgkj/AAA-HEX7Co0KE8LoIZCii4fta?dl=0
- karthik

Pricing:
Black Gildan long sleeve no pocket - $21/shirt for 40


PRINT FILES: url',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-5 days',
                'text'    => 'Hey Sarah,

Thanks for placing a design request with Greek House. As a reminder, to get your Order in by 05/22/2018, here are some dates to keep us on track:
- Approve Design by 05/04/2018
- Submit Sizes by 05/08/2018

Please let us know if you have any questions or concerns! ',
            ],
            [
                'user'    => null,
                'created' => '-3 days',
                'text'    => 'Designer Luke has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Hi!

I LOVE the design! Could we maybe have the Frocket Alpha Phi letters actually lay flat on the and not at an angle? And then outline the Aphi letters on the frocket in white as well. ',
            ],
            [
                'user'    => 'support2',
                'created' => '-2 days',
                'text'    => 'Greek House has requested a revision for Alpha Phi Formal Shirt
+luke- please see above for revisions. thanks ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Can we also make the yellow a bit more pastel-like. It has a bit of a greenish tint to it currently. ',
            ],
        ],
    ],
];
