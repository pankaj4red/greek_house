<?php

return [
    [
        'name'               => 'Recruitment Workshop',
        'user'               => 'customer',
        'delivery'           => 'flexible',
        'estimated_quantity' => '72-143',
        'state'              => 'awaiting_quote',
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
                'designer_assigned' => '-1 days',
            ],
            'hourly_rate'             => 30.00,
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            'G2200' => ['Green', 'Slate', 'Brown'],
            'B4070' => ['Slate'],
        ],
        'times'              => [
            'created'           => '-3 days',
            'awaiting_design'   => '-2 days',
            'awaiting_approval' => '-2 days',
            'awaiting_quote'    => '-1 days',
        ],
        'comments'           => [
            [
                'user'    => null,
                'created' => '-3 days',
                'text'    => 'Hey Colleen,

Thanks for placing a design request with Greek House.

Please let us know if you have any questions or concerns!',
            ],
            [
                'user'    => null,
                'created' => '-3 days',
                'text'    => 'Designer Ian has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => 'Mason Mello has requested a revision for Recruitment Workshop
+Ian Could you change some of the pink on the back to the turquoise color and put "Recruitment Workshop 2018" underneath the circle in white and underneath the letters on the front in the turquoise color? Thanks so much! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-2 days',
                'text'    => '+Ian Could you also change "Theta" on the back design to say "Delta" instead?',
            ],
            [
                'user'    => 'designer',
                'created' => '-2 days',
                'text'    => '
Designer Ian has uploaded a proof! ',
            ],
            [
                'user'    => 'customer',
                'created' => '-1 days',
                'text'    => 'Colleen has approved the design for Recruitment Workshop',
            ],
        ],
    ],
];
