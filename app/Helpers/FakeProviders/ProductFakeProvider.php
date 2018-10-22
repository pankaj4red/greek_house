<?php

namespace App\Helpers\FakeProviders;

class ProductFakeProvider extends \Faker\Provider\Base
{
    private $list = [
        'American Apparel Short Sleeve T-shirt',
        'American Apparel Long Sleeve T-Shirt',
        'American Apparel Fine Jersey Tank',
        'Comfort Colors Tank Top',
        'Comfort Colors Pocket T-Shirt',
        'Comfort Colors T-Shirt',
        'Comfort Colors Long Sleeve T-Shirt',
        'Comfort Colors Long-Sleeve Pocket T-Shirt',
        'Gildan Long Sleeve w/ Pocket',
        'Gildan T-Shirt',
        'Gildan T-Shirt with Pocket',
        'Next Level The Boyfriend Tee',
        'Gildan Tank',
        'Gildan Softstyle T-Shirt',
        'Bella + Canvas Unisex Jersey Tank',
        'Bella Rib Racerback Longer Length Tank',
        'Next Level Short Sleeve Crew',
        'Bella Short Sleeve T-Shirt',
        'Anvil Lightweight V-Neck Tee-Shirt',
        'Bella Short-Sleeve V-Neck T-Shirt',
        'Comfort Colors Crew Neck Sweatshirt',
        'Bella Triblend Racerback Tank',
        'Bella + Canvas Long Sleeve Baseball Tee',
        'Anvil Baseball T-Shirt',
        'Bella + Canvas Unisex Triblend Short-Sleeve V-Neck Tee',
        'Next Level Tank',
        'Gildan Long Sleeve T-Shirt',
        'Hanes T-Shirt with Pocket',
        'American Apparel 50/50 T-Shirt',
        'American Apparel 50/50 Tank Top',
        'Bella Long-Sleeve T-Shirt',
        'Hanes Longsleeve w/ Pocket',
        'Gildan Crew Neck Sweatshirt',
        'Gildan Hooded Sweatshirt',
        'Jerzees Ladie\'s Polo',
        'Hanes Crew Neck Fleece',
        'Hanes ComfortBlend® Hooded Pullover Fleece',
        'Jerzees Quarter Zip Sweatshirt',
        'Nike Dri-Fit Polo',
        'Bella TriblendRacerback Tank',
        'Bella Mini Pique Polo',
        'Bella & Canvas V-Neck',
        'Bella Fleece Full Zip Raglan Hoodie',
        'Bella Flowy Racerback Tank Top',
        'Bella - Legging',
        'American Apparel 3/4 Sleeve Raglan',
        'American Apparel Ladies Short Sleeve T-Shirt',
        'American Apparel Racerback Tank Dress',
        'American Apparel Pocket T-Shirt',
        'American Apparel V-Neck T-Shirt',
        'American Apparel Short Sleeve Deep V-Neck T-Shirt',
        'American Apparel Cotton Spandex Yoga Pant',
        'American Apparel Cotten Spandex Tank Top',
        'American Apparel Jersey Leggings',
        'American Apparel Flex Fleece Zip Hoodie',
        'American Apparel Classic Pullover Hoodie',
        'American Apparel Fine Jersey Racerback Tank Top',
        'American Apparel Oversized Viscose Tank',
        'American Apparel Tri-Blend Track T-Shirt',
        'American Apparel Tri-Blend Racerback Tank Top',
        'American Apparel Tri-Blend Tank Top',
        'American Apparel Tri-Blend V-Neck T-Shirt',
        'Classic Crew Neck Spirit Jersey',
        'Port & Company - Pigment-Dyed Tee',
        'Port & Company - Pigment-Dyed Pocket Tee',
        'Port & Company - Pigment-Dyed Long Sleeve Pocket Tee',
        'Gildan - Dry Blend Fleece Stadium Blanket',
        'Columbia - Men\'s Tamiami™ II Long-Sleeve Shirt',
        'Augusta - Fleece Sport Headband',
        'UltraClub - Boat Toat',
        'UltraClub - Zippered Tote Bag',
        'Columbia - Women\'s Bahama II Long Sleeve Shirt',
        'Columbia - Women\'s Bahama II Short Sleeve Shirt',
        'Columbia - Men\'s Bahama II Long Sleeve Shirt',
        'Columbia - Men\'s Bahama II Short Sleeve Shirt',
        'Coozie',
        'Velour Beach Towel',
        'Strech Fleece Headband',
        'Augusta Striped Sleeve Jersey T-Shirt',
        'American Apparel - Headband',
        'Cabana Stripe Beach Towel',
        'Augusta - Training Short With Pockets',
        'Augusta - Nova Jersey',
        'Port and Company - Sweatshirt Blanket',
        'Augusta - Motion Crew',
        'Bella - Flowy V-Neck Dress',
        'Bella - Vintage Dress',
        'Augusta - Training Tank',
        'American Apparel - Racerback Dress',
        'Bella - Women\'s Fleece Wide Neck Sweatshirt',
        'Augusta - Mini Mesh League Short',
        'Bella - Half-Zip Hooded Pullover',
        'Augusta - Shooter Shirt',
        'Augusta - Reversible Mini Mesh Singlet',
        'Augusta - Reversible Mini Mesh League Tank',
        'Augusta - Hyperform Compression Short Sleeve T-Shirt',
        'Jerzees - 1/4 Zip Sweatshirt',
        'American Apparel - Classic Crewneck',
        'Augusta - Ladies Rave Henley',
        'Augusta - Ladies Exa Jersey',
        'Columbia - Columbia Men\'s Ascender Soft Shell',
        'Columbia - Women\'s Benton Springs Vest',
        'Columbia - Men\'s Cathedral Peak II Vest',
        'Columbia - Women\'s Benton Springs Full-Zip Fleece',
        'Columbia - Women\'s Crescent Valley 1/4 Zip Fleece',
        'Columbia - Men\'s Crescent Valley 1/4 Zip Fleece',
        'Columbia - Men\'s Steens Mountain Full-Zip Fleece',
        'American Apparel - Pull Over Hoodie',
        'Augusta - Slugger Jersey',
        'Alternative Apparel - Jogger Fleece Pants',
        'District - Core Fleece Pant',
        'District - Fleece Onsie',
        'Bella - Cotton Leggings',
        'Bella - Poly-Cotton Fleece Long Scrunch Pant',
        'Bella - Cotton Fitness Pants',
        'Bella - Vintage Jersey Lounge Pant',
        'Soffe - Team Shorty Shorts',
        'Bayside - Beanie',
        'Bayside - Knit Cuff Beanie',
        'Yupoong - Flexfit® Cap',
        'Adams - Optimum II True Color Cap',
        'Charles River - Anorak',
        'Patagonia - Men\'s Micro D Pullover',
        'Patagonia - Men\'s Synchilla Fleece',
        'Patagonia - Men\'s Micro D Jacket',
        'Patagonia - Men\'s Synchilla Snap-T Fleece Pullover',
        'Patagonia- Women\'s Synchilla Snap-T Fleece Pullover',
        'Augusta - Fury Jacket',
        'Augusta - Fury Jacket',
        'Bella + Canvas - Women\'s Flowy Raglan Tee',
        'Women\'s Flowy V-Neck Tank',
        'Bella + Canvas Women\'s Slouchy Tee',
        'Women\'s Flowy V-Neck Tank',
        'Womens Flowy Long Sleeve Tee With 2x1 Sleeves',
        'Triblend Short Sleeve Tee',
        'Bella + Canvas Ladies\' Flowy Boxy Cropped Crewneck T-Shirt',
        'District Juniors V.I.T.™ Festival Tank',
        'Next Level Men\'s Tri-Blend',
        'Next Level Men\'s Premium Sueded V shirt',
        'Comfort Colors Pocket Tank',
        'Bella + Canvas Ladies\' Jersey Short-Sleeve Deep V-Neck Tee',
        'Ladies Modal Blend Relaxed V-Neck Tee.',
        'Bella +Canvas Ladies\' Slouchy V-Neck Tee',
        'Bella Tri-Blend Deep V-Neck',
        'Bella flowy 1/2 sleeve cropped V-Neck tee',
        'Bella Flowy Boxy Tank',
        'Bella Flowy Circle Top',
        'Bella Flowy Draped Sleeve Dolman T-Shirt',
        'Bella + Canvas Ladies\' Flowy Long-Sleeve Off-Shoulder Tee',
        'Dyenomite Adult Spiral Tank Top',
        'Bella Flowy Open Back Tee',
        'American Apparel Thick Knit Baseball Jersey',
        'Augusta Stadium Replica Jersey',
        'District Made® - Ladies Modal Blend Tank',
        'District® - Juniors 60/40 Racerback Tank',
        'Cotton Spandex Jersey Crop Tee',
        'Cotton Spandex Sleeveless Crop Top',
        'Poly-Cotton Cropped 3/4 Sleeve Raglan',
        'American Apparel Loose Crop Tank',
        'Next Level Ladies Triblend Dolman',
        'Bella + Canvas Flowy Muscle Tank',
        'Charles River - Classic Solid Pull Over',
        'WOMEN\'S 1.5" PRINTED SPLIT TRAINER RUNNING SHORT',
        'Sport-Tek® Long Sleeve PosiCharge® Competitor™ Tee',
        'A4 Performance Crew Socks',
        'BELLA+CANVAS Ladies\' Slouchy Tank',
        'Next Level The Ideal V',
        'Bella+Canvas Women\'s Jersey Short Sleeve Ringer Tee',
        'Next Level The Terry Racerback Tank',
        'Men\'s Triblend Short Sleeve Henley',
        'Men\'s Triblend Short Sleeve Henley',
        'Women\'s Sheer Mini Rib Racerback Tank',
        'Authentic Pigment Boat Tote Pocket',
        'Bagedge Boat Tote Front Pocket',
        'Bagedge Boat Tote No Front Pocket',
        'Bagedge Canvas Tote Bag',
        'Bagedge Zippered Canvas Tote',
        'Fanny Pack',
        'Jansport Backpack Right Pack',
        'Reusable Tote Bag',
        '16oz Spirit Tumbler',
        '25oz H2go Mason',
        '32oz Vornado',
        '5866 16oz Tumblr',
        '5899 Polyclear 24 Fitness Bottle',
        'Cup2go',
        'Edge Waterbottle',
        'Hpi Slap Koozie',
        'Kk Neoprene Stitched Koozie',
        'Button Pin',
        'Silicone Card Sleeve',
        'Sport-Tek® PosiCharge® RacerMesh™ Polo',
        'Xclusive Eco-Hybrid Micro Jersey Marble Dye High Neck Tank',
        'Xclusive Micro Jersey Deep Side Cut Ombre Dye Muscle Tank',
        'Nike Golf Dri-FIT Solid Icon Pique Modern Fit Polo',
        'Nike Golf Dri-FIT Tech Stripe Polo',
        'Nike Golf Dri-FIT Fade Stripe Polo',
        'Nike Training Tee',
        'Men\'s Jersey Long Sleeve Henley',
        'Women\'s Jersey Short Sleeve Ringer Tee',
        'Unisex Sponge Fleece Raglan Sweatshirt',
        'Women\'s Baby Rib Short Sleeve Ringer Tee',
        'Women’s Heathered Fleece Pullover',
        'Sport-Tek® 1/4-Zip Sweatshirt',
        'Flexfit Bucket Hat',
        'Dyenomite Adult Typhoon Tee',
        'Women\'s Varsity Sweatshirt',
        'Women\'s Baby Rib Spaghetti Strap Tank',
        'Women\'s Cotton Spandex Camisole',
        'Unisex Jogger Sweatpants',
        'Backpacker Men\'s Yarn-Dyed Flannel Shirt',
        'Alternative Men\'s Short-Sleeve Henley',
        'MOCO eco-HYBRID™ Micro Jersey Pullover Hoodie',
        'PopSockets',
        'Harriton 8 oz. Quarter-Zip Fleece Pullover',
        'Vacuum Sealed Double Wall Heavy Duty Stainless Steel Travel',
        'Next Level Mens Triblend Crew',
        'Adams 6-Panel Low-Profile Washed Pigment-Dyed Cap',
        'BAGedge Tech Backpack',
        'Ash City - Core 365 Cruise Fleece',
        'Anvil Midweight Pocket T-Shirt',
        'Anvil Midweight Long Sleeves T-Shirt',
        'Women\'s Flowy High Neck Tank',
        'Authentic Pigment Ladies\' XtraFine T-Shirt',
        'econscious 7 oz. Recycled Cotton Everyday Tote',
        'Custom Product - Unisex',
        'Custom Product - Womens',
        'Custom Product - One Size',
        'KC Beanie With Pom Pom',
        'Sport-Tek Stripe Pom Pom Beanie',
        'Adirondack Fleece Pullover',
        'Sport-Tek® PosiCharge® RacerMesh™ Tee. ST340.',
        'American Apparel - Cropped Sweatshirt',
        'Port & Company® Core Cotton Camo Tee',
        'Nike Team Legend Short-Sleeve Crew T-Shirt',
        'Champion Double Dry Eco Pullover Hood',
        'GILDAN HEAVY BLEND ADULT CREWNECK SWEATSHIRT',
        'BELLA + CANVAS WOMEN\'S RELAXED JERSEY SHORT SLEEVE TEE',
        'Bella + Canvas Ladies Relaxed Jersey Short-Sleeve V-Neck T-Shirt',
        'BELLA + CANVAS WOMEN\'S NYLON SPANDEX SPORTS BRA',
        'MOCO eco-HYBRID™ Micro Jersey Pullover Hoodie',
        'Bella Flowy Long-Sleeve with 2x1 Sleeves',
        'Next Level Apparel The PCH Hooded Pullover Sweatshirt',
        'Unisex Sponge Fleece Full-Zip Hoodie',
        '15 oz. Color Changing Mug - Black',
        '15 oz ceramic mug',
        '11 oz Color Changing Mug (Blue)',
        '17 oz. Color Changing Latte Mug',
        'J AMERICA MEN\'S VINTAGE BRUSHED LONG SLEEVE JERSEY HENLEY',
        'Yupoong Adult 6-Panel Structured Flat Visor Classic Snapback',
        'A4 Drop Ship Adult Tek 2-Button Henley Jersey',
        'District Made® Ladies 60/40 Racerback Dress',
        'Bella Women\'s Flowy Tank with Side Slit',
        'NIKECOURT PURE WOMEN\'S 17" TENNIS SKIRT',
    ];

    public function product()
    {
        return $this->list[rand(0, count($this->list) - 1)];
    }
}