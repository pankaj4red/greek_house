<?php

return [
    [
        'name'               => 'dsp pin',
        'user'               => 'customer',
        'delivery'           => 'flexible',
        'estimated_quantity' => '48-71',
        'state'              => 'on_hold',
        'on_hold_reason'     => null,
        'on_hold_category'   => 'new_customer',
        'on_hold_rule'       => 'App\Helpers\OnHold\NewCustomerRule',
        'on_hold_actor'      => 'customer',
        'artwork'            => [
            'front'                   => [
                'colors'      => 2,
                'description' => 'Kappa Sigma \'18 and University of Florida underneath it.',
            ],
            'back'                    => [
                'colors'      => 3,
                'description' => 'SEE NEW IMAGE IN MESSAGES FOR THE BACK - INCLUDE THE KΣ letters instead',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '18500' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created' => '-1 days',
            'on_hold' => '-1 days',
        ],
        'internal_notes'     => [
            [
                'type'    => 'on_hold_note',
                'content' => 'The estimated price per piece comes out to {$98.87 - $98.87} for 26176 - Patagonia - Men\'s Micro D Fleece Pullover w/ 1 color on front for 24-47 pieces. ',
            ],
        ],
        'comments'           => [
            [
                'user'    => null,
                'created' => '-1 days',
                'text'    => 'Hey Brooke
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
        'name'               => 'Kappa Sig NM shirt',
        'user'               => 'customer2',
        'delivery'           => 'rush',
        'estimated_quantity' => '48-71',
        'state'              => 'on_hold',
        'on_hold_reason'     => null,
        'on_hold_category'   => 'high_risk',
        'on_hold_rule'       => 'App\Helpers\OnHold\TooManyDesignRequestsRule',
        'on_hold_actor'      => 'customer2',
        'artwork'            => [
            'front'                   => [
                'colors'      => 2,
                'description' => 'Use the attached pdf / images and create a new logo/design for this year. Maybe do 2 versions?
Use same logo colors though.',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '3900' => ['Green', 'Slate', 'Brown'],
        ],
        'times'              => [
            'created' => '-2 days',
            'on_hold' => '-2 days',
        ],
        'notes'              => '5/9 - Jordan text on Salesforce - cancelled first order and has an order in Collecting Payment now without any orders
5/11 - Karthik spoke to him on the phone; said he will have sizes in the next few weeks. Once he does, we can push this design through.',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-2 days',
                'text'    => 'Hey Chris
Your campaign is currently being reviewed by our customer success team to ensure you have a successful campaign!
This campaign is being reviewed for the following reasons:

    You only have Cancelled Designs -OR- too many Cancelled Designs
    You have too many Campaigns Open -OR- we\'re awaiting a response from you on another Campaign

Are you available for a quick call?
You can also schedule a time using the following link: https://calendly.com/greekhouse/review
We’ll answer any questions and ensure your campaign is successful!
Best,
Greek House ',
            ],
            [
                'user'    => 'support',
                'created' => '-1 days',
                'text'    => 'Hey Chris! Did you plan on going through with both these and the Summer Rush shirts? Usually we don\'t allow for multiple designs until you\'ve had a successful order with us, so let us know what you plan is!',
            ],
            [
                'user'    => 'support',
                'created' => '-0 days',
                'text'    => 'Let us know what your plan is for these!',
            ],
        ],
    ],
    [
        'name'               => 'Fall Rush 2018 - 1',
        'user'               => 'member',
        'delivery'           => '+20 days',
        'estimated_quantity' => '48-71',
        'state'              => 'on_hold',
        'on_hold_reason'     => null,
        'on_hold_category'   => null,
        'on_hold_rule'       => null,
        'on_hold_actor'      => 'member',
        'artwork'            => [
            'front'                   => [
                'colors'      => 4,
                'description' => '- attached is their Santa the customer wants to use in the design
- attached is 2017\'s design > USE THE SAME EXACT COPYWRITING, BUT CHANGE IT TO 2018; feel free to rearrange the copy too
- there is a 3rd picture of another shirt they did, but without the year

- Few additional pictures that will be attached in the message board / Designer Notes:
1. pictures of the venue / course
2. 25 ft inflatable snowman that is part of the course
3. their company logo (IN CASE WE WANT TO INCORPORATE IT, BUT MAYBE TOO BUSY)
- KEEP IT 4 COLORS
4. I will include the fonts they like to use in the Designer Notes',
            ],
            'design_style_preference' => 'cartoon',
            'design_type'             => 'screen',
        ],
        'images'             => ['Campaigns/Images/rgb.svg', 'Campaigns/Images/layers.svg'],
        'products'           => [
            '2007' => ['Green', 'Slate', 'Brown'],
            '6753' => ['Coral', 'Purple'],
        ],
        'times'              => [
            'created' => '-3 days',
            'on_hold' => '-3 days',
        ],
        'internal_notes'     => [
            [
                'type'    => 'on_hold_note',
                'content' => 'The estimated price per piece comes out to {$20.18 - $25.63} for - BELLA+CANVAS Ladies\' Slouchy Tank w/ 4 colors on front for 24-47 pieces.',
            ],
        ],
        'notes'              => '5/11 - call lvm. - Karthik',
        'comments'           => [
            [
                'user'    => null,
                'created' => '-1 days',
                'text'    => 'Hey Colten
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
];