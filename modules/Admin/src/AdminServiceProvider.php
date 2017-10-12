<?php

/**
 *  ServiceProvider file for Admin module
 *
 * @name       AdminServiceProvider.php
 * @category   ServiceProvider
 * @package    Admin
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * ServiceProvider class for Admin module
 *
 * @name AdminServiceProvider
 * @category ServiceProvider
 * @package Admin
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class AdminServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @name boot
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
       // get theme name
        $theme = Config::get('app.theme');
        // set theme path
        $this->loadViewsFrom(__DIR__ . '/Views', 'Admin');
        
        // Copy admin theme
        $sourceJs = realpath(__DIR__ . '/../public/admin/js'); 	 
   
        $this->publishes([
            $sourceJs => base_path('public/theme/'.$theme.'/assets/admin/js/')
        ]);
		
        $this->loadMigrationsFrom(__DIR__ . '/path/to/migrations');
        
        // include route file of this package
        include __DIR__ . '/routes.php';
    }

    /**
     * Register the application services.
     *
     * @name boot
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Admin', function ($app) {
            return new Admin();
        });
    }
}
