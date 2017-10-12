<?php

/**
 * PagesServiceProvider class to add / edit / delete pages
 *
 * @name       PagesServiceProvider.php
 * @category   ServiceProvider
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 753130cdf08b0bf1e868b7ad84662cecc137bb2f $
 * @link       None
 * @filesource
 */
namespace Modules\Pages;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * PagesServiceProvider class to add / edit / delete pages
 *
 * @name PagesServiceProvider.php
 * @category ServiceProvider
 * @package Pages
 * @author Vivek Kale <vivek.kale@silicus.com>
 * @license Silicus http://www.silicus.com/
 * @version GIT: $Id: 753130cdf08b0bf1e868b7ad84662cecc137bb2f $
 * @link None
 * @filesource
 *
 */
class PagesServiceProvider extends ServiceProvider
{

    /**
     * This will register your module.
     *
     * @name register
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Pages', function ($app) {
            return new Pages();
        });
    }

    /**
     * This will perform post-registration booting of services.
     *
     * @name register
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
        // loading the routes files
        include __DIR__ . '/routes.php';
        
        // define the path to view files
        $this->loadViewsFrom(__DIR__ . '/Views', 'pages');
        
        // define files which are going to be published
        
        $adminTheme = Config::get('app.adminTheme');
        
        $this->publishes([
            __DIR__ . '/Views/pages/js/pages.js' => base_path('public/theme/' . $adminTheme . '/assets/pages/js/pages.js'),
            __DIR__ . '/Views/pages/js/page_categories.js' => base_path('public/theme/' . $adminTheme . '/assets/pages/js/page_categories.js')
        ]);
        
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        
        $this->loadMigrationsFrom($sourceMigration);
    }
}
