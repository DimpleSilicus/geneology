<?php

/**
 *  ServiceProvider file for Faq module
 *
 * @name       FaqServiceProvider.php
 * @category   ServiceProvider
 * @package    Faq
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Faq;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider class for Faq module
 *
 * @name FaqServiceProvider
 * @category ServiceProvider
 * @package Faq
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class FaqServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/Views', 'Faq');
        
        // For js
        $sourceJs = realpath(__DIR__ . '/../public/theme/default');
        $this->publishes([
            $sourceJs => base_path('public/theme/admin/assets/')
        ]);
        
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
        
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
    {}
}
