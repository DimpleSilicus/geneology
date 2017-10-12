<?php

/**
 * MapsServiceProvider service provider for publish images, css and js.
 *
 * @name       MapsServiceProvider
 * @category   ServiceProvider
 * @package    Maps
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Maps;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * MapsServiceProvider for publish images, css, js
 *
 * @name MapsServiceProvider
 * @category ServiceProvider
 * @package    Maps
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class MapsServiceProvider extends ServiceProvider
{

    /**
     * For register our service provider
     *
     * @name register
     * @access public
     * @author     Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Maps', function ($app) {
            return new Maps();
        });
    }

    /**
     * This function is for send migration files in migration folder
     *
     * @name boot
     * @access public
     * @author     Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
        // get theme name
        $theme = Config::get('app.theme');
        
        // set theme path
        $this->loadViewsFrom(__DIR__ . '/Views/', 'Maps');
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        // $this->publishes([$sourceMigration => database_path('migrations')]);
        $this->loadMigrationsFrom($sourceMigration);
        // For js
        $sourceJs = realpath(__DIR__ . '/../public/maps/js/');
		
        
        $this->publishes([
            $sourceJs => base_path('public/theme/' . $theme . '/assets/maps/js/')
        ]);
        
        // include route file of this package
        include __DIR__ . '/routes.php';
    }
}
