<?php

/**
 *  ServiceProvider file for @USample@ module
 *
 * @name       @USample@ServiceProvider.php
 * @category   ServiceProvider
 * @package    @USample@
 * @author     Swati jadhav <swati.jadhav@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\@USample@;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider class for @USample@ module
 *
 * @name     @USample@ServiceProvider
 * @category ServiceProvider
 * @package  @USample@
 * @author   Swati jadhav <swati.jadhav@silicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class @USample@ServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @name   boot
     * @access public
     * @author Swati jadhav <swati.jadhav@silicus.com>
     *
     * @return void
     */
    public function boot()
    {

        //get theme name
        $theme = Config::get('app.theme');

        //set theme path
        $this->loadViewsFrom(__DIR__ . '/Views/' . $theme, '@USample@');

        //For js
        $sourceJs  = realpath(__DIR__ . '/js');
        $this->publishes([$sourceJs => base_path('public/theme/' . $theme . '/assets/@LSample@/js/')]);

        //include route file of this package
        include __DIR__ . '/routes.php';
    }

    /**
     * Register the application services.
     *
     * @name   boot
     * @access public
     * @author Swati jadhav <swati.jadhav@silicus.com>
     *
     * @return void
     */
    public function register()
    {

    }

}
