<?php

namespace App\Providers;

use App\Helpers\FakeProviders\AddressNameFakeProvider;
use App\Helpers\FakeProviders\ChapterFakeProvider;
use App\Helpers\FakeProviders\ColorFakeProvider;
use App\Helpers\FakeProviders\DesignTagChapterFakeProvider;
use App\Helpers\FakeProviders\DesignTagCollegeFakeProvider;
use App\Helpers\FakeProviders\DesignTagEventFakeProvider;
use App\Helpers\FakeProviders\DesignTagGeneralFakeProvider;
use App\Helpers\FakeProviders\DesignTagProductTypeFakeProvider;
use App\Helpers\FakeProviders\DesignTagThemesFakeProvider;
use App\Helpers\FakeProviders\FilenameFakeProvider;
use App\Helpers\FakeProviders\GarmentBrandFakeProvider;
use App\Helpers\FakeProviders\GarmentCategoryFakeProvider;
use App\Helpers\FakeProviders\GenderFakeProvider;
use App\Helpers\FakeProviders\LoremIpsumFakeProvider;
use App\Helpers\FakeProviders\ProductFakeProvider;
use App\Helpers\FakeProviders\SizeFakeProvider;
use App\Helpers\FakeProviders\SkuFakeProvider;
use App\Helpers\FakeProviders\TagFakeProvider;
use App\Helpers\FakeProviders\USStateFakeProvider;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Faker\Generator::class, function ($app) {
            $faker = \Faker\Factory::create();
            $faker->addProvider(new ChapterFakeProvider($faker));
            $faker->addProvider(new FilenameFakeProvider($faker));
            $faker->addProvider(new ColorFakeProvider($faker));
            $faker->addProvider(new ProductFakeProvider($faker));
            $faker->addProvider(new GenderFakeProvider($faker));
            $faker->addProvider(new GarmentCategoryFakeProvider($faker));
            $faker->addProvider(new GarmentBrandFakeProvider($faker));
            $faker->addProvider(new SkuFakeProvider($faker));
            $faker->addProvider(new SizeFakeProvider($faker));
            $faker->addProvider(new USStateFakeProvider($faker));
            $faker->addProvider(new AddressNameFakeProvider($faker));
            $faker->addProvider(new TagFakeProvider($faker));
            $faker->addProvider(new LoremIpsumFakeProvider($faker));
            $faker->addProvider(new DesignTagGeneralFakeProvider($faker));
            $faker->addProvider(new DesignTagChapterFakeProvider($faker));
            $faker->addProvider(new DesignTagCollegeFakeProvider($faker));
            $faker->addProvider(new DesignTagEventFakeProvider($faker));
            $faker->addProvider(new DesignTagProductTypeFakeProvider($faker));
            $faker->addProvider(new DesignTagThemesFakeProvider($faker));

            return $faker;
        });
    }
}
