<?php

return [
    [
        'name'               => 'Fire Cracker 5K',
        'user'               => 'customer',
        'delivery'           => '+14 days',
        'estimated_quantity' => '24-47',
        'state'              => 'cancelled',
        'artwork'            => [
            'pocket'                  => [
                'colors'      => 2,
                'description' => '1. \'ΦΔΘ\' at the top
2. \'Phloat Trip\' under the letters
3. Criss-crossed wooden paddles behind the letters',
            ],
            'back'                    => [
                'colors'      => 4,
                'description' => '1. \'ΦΔΘ\' wooden letters at the top
2. \'Phloat Trip\' underneath the letters
3. Small design such as splashes on each side of the words
4. Lake scene with a person in a tube with red coolers standing and paddling
5. 2 other tubes with just coolers
6. 2 guys in the water holding their paddles in the air
7. Trees/sun/sunset in the background
8. \'2018\' at the bottom',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '3000' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'         => '-2 days',
            'on_hold'         => '-2 days',
            'awaiting_design' => '-1 days',
        ],
        'internal_notes'     => [
            [
                'type'    => 'on_hold_note',
                'content' => 'The estimated price per piece comes out to {$19.16 - $26.00} for 6030 - Comfort Colors Pocket T-Shirt w/ 4 colors on back / 2 colors on pocket for 24-47 pieces.',
            ],
        ],
        'notes'              => 'NO BAG N TAG. 
PRICE AROUND $19 FOR 24 PIECES. FOR 47 PIECES $18 OR SO.
- Karthik',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-1 days',
                'text'    => 'Hey Marina
Thanks for placing a design request and welcome to Greek House!
We see that this is your first order and want to make sure your experience is perfect. Are you available for a quick call?
You can schedule a time using the following link: https://calendly.com/greekhouse/review
If you would rather chat here, can you let us know if you have a budget or price per piece you\'re looking for?
Happy to make this work for your chapter! Once we hear back, we\'ll get you a design back within 24 hours.
Best,
Greek House',
            ],
        ],
    ],
    [
        'name'               => 'Theta Phi Alpha Bid Day Shirts p1',
        'user'               => 'customer2',
        'delivery'           => '+18 days',
        'estimated_quantity' => '24-47',
        'state'              => 'awaiting_design',
        'artwork'            => [
            'front'                   => [
                'colors'      => 1,
                'description' => 'Similar to the shirt to the right of the photo I uploaded',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '2400' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'         => '-3 days',
            'on_hold'         => '-3 days',
            'awaiting_design' => '-2 days',
        ],
        'comments'           => [
            [
                'user'    => null,
                'created' => '-1 days',
                'text'    => 'Hey Connor
Your campaign is currently being reviewed by our customer success team to ensure you have a successful campaign!
This campaign is being reviewed for the following reasons:

    You only have Cancelled Designs -OR- too many Cancelled Designs
    You have too many Campaigns Open -OR- we\'re awaiting a response from you on another Campaign

Are you available for a quick call?
You can also schedule a time using the following link: https://calendly.com/greekhouse/review
We’ll answer any questions and ensure your campaign is successful!
Best,
Greek House',
            ],
            [
                'user'    => 'support2',
                'created' => '-1 days',
                'text'    => 'Hey Connor, Greek Licensing said the "AF" isn\'t approved. What would you like to change it to?',
            ],
        ],
    ],
    [
        'name'               => 'DZ Embroidery',
        'user'               => 'member2',
        'delivery'           => '+15 days',
        'estimated_quantity' => '12-23',
        'state'              => 'awaiting_design',
        'artwork'            => [
            'front'                   => [
                'colors'      => 1,
                'description' => '"Delta Zeta", in WHITE, CURSIVE, EMBROIDERED',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'embroidery',
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '7002' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created'         => '-4 days',
            'awaiting_design' => '-1 days',
        ],
        'comments'           => [
            [
                'user'    => null,
                'created' => '-4 days',
                'text'    => 'Hey Kiki,

Thanks for placing a design request with Greek House.

Please let us know if you have any questions or concerns! ',
            ],
            [
                'user'    => 'support',
                'created' => '-1 days',
                'text'    => 'Hey Kiki, Greek Licensing said Delta Zeta does not approve crop tops! Are you open to changing up the style garment? We have other different flowy options that are not crop tops!',
            ],
        ],
    ],
];
