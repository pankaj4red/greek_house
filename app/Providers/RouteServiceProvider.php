<?php

namespace App\Providers;

use App\Exceptions\RedirectException;
use App\Logging\Logger;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('campaign_checkout', function ($value) {
            if (! is_integer($value)) {
                $value = get_product_id_from_description($value);
            }
            $campaign = campaign_repository()->find($value);
            // Check if Campaign Exists
            if (! $campaign) {
                Logger::logWarning('#Campaign does #NotExists #Checkout');
                throw new RedirectException(route('home::index'), 'The campaign you are looking for does not exist.');
            }

            // Check if Campaign is Collecting Payment
            if ($campaign->state != 'collecting_payment') {
                throw new RedirectException(route('home::index'), 'The campaign you are looking for is not collecting payments at the moment.');
            }

            return $campaign;
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapSystemRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    protected function mapSystemRoutes()
    {
        Route::middleware('system')->namespace($this->namespace)->group(base_path('routes/system.php'));
    }

    /**
     * Define the "api" routes for the application.
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }
}
