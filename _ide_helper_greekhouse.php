<?php
/**
 * A helper file for Laravel 5, to provide autocomplete information to your IDE
 * Generated for Laravel 5.4.23 on 2017-06-03.
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 * @see    https://github.com/barryvdh/laravel-ide-helper
 */

namespace
{
    
    exit("This file should not be included, only analyzed by your IDE");
}

namespace Illuminate\Support
{
    
    /**
     * @method Fluent first()
     * @method Fluent before($column)
     * @method Fluent after($column)
     * @method Fluent change()
     * @method Fluent nullable()
     * @method Fluent unsigned()
     * @method Fluent unique()
     * @method Fluent index()
     * @method Fluent primary()
     * @method Fluent default($value)
     * @method Fluent onUpdate($value)
     * @method Fluent onDelete($value)
     * @method Fluent references($value)
     * @method Fluent on($value)
     * @method Fluent useCurrent()
     */
    class Fluent
    {
    }
}

namespace Illuminate\Database\Eloquent\Relations
{
    
    /**
     * @method \Illuminate\Database\Query\Builder where($param1, $param2 = null, $param3 = null)
     */
    class HasMany
    {
    }
}


namespace
{
    
    class Auth
    {
        public static function routes()
        {
            //
        }
    }
    
    class Broadcast extends \Illuminate\Support\Facades\Broadcast
    {
        /**
         * @param $xpath
         * @param $callback
         * @returns boolean
         */
        public static function channel($xpath, $callback)
        {
            /** @noinspection PhpUndefinedMethodInspection */
            return parent::channel();
        }
    }
    
    class Request
    {
        public static function is($url)
        {
            return \Illuminate\Http\Request::is($url);
        }
    }
}

namespace Faker
{
    
    /**
     * @property string $chapter
     * @property string $image_filename
     * @property string $file_filename
     * @property string $product
     * @property string $color
     * @property string $gender
     * @property string $garment_brand
     * @property string $garment_category
     * @property string $sku
     * @property array  $size
     * @property array  $us_state
     * @property string $address_name
     * @property string $tag
     * @property string $lorem_ipsum
     * @property string $design_tag_general
     * @property string $design_tag_themes
     * @property string $design_tag_event
     * @property string $design_tag_college
     * @property string $design_tag_chapter
     * @property string $design_tag_product_type
     */
    class Generator
    {
        public function lorem_ipsum($sentenceCount = 3)
        {
            return '';
        }
    }
}

namespace Illuminate\Routing
{
    
    class Router
    {
        public function prefix($name)
        {
            return $this;
        }
    }
}

namespace Mockery
{
    
    class MockInterface
    {
        /**
         * @param $method
         * @return MockInterface|Expectation
         */
        public function shouldReceive($method)
        {
        
        }
    }
}

namespace Illuminate\Support\Facades
{
    class Notification
    {
        /**
         * Assert if a notification was sent based on a truth-test callback.
         *
         * @param  mixed  $notifiable
         * @param  string  $notification
         * @param  callable|null  $callback
         * @return void
         */
        public static function assertSentTo($notifiable, $notification, $callback = null)
        {
        
        }
    }
}


