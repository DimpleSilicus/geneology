<?php

/**
 * Activitylog service provider for publish images, css and js.
 *
 * @name       ActivitylogServiceProvider
 * @category   Module
 * @package    Activitylog
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\ActivityLog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * ActivitylogServiceProvider for publish images, css, js
 *
 * @name ActivitylogServiceProvider
 * @category ServiceProvider
 * @package Activitylog
 * @author Vivek Bansal <vivek.bansal@silicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class ActivityLogServiceProvider extends ServiceProvider
{

    /**
     * For register our service provider
     *
     * @name register
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function register()
    {}

    /**
     * This function is for send migration files in migration folder
     *
     * @name boot
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/routes.php';
        // LOAD VIEW FILES
        $this->loadViewsFrom(__DIR__ . '/Views', 'AL');
        $adminTheme = Config::get('app.adminTheme');
        $this->publishes([
            realpath(__DIR__ . '/../public/js/custom.js') => base_path('public/theme/' . $adminTheme . '/assets/ActivityLog/js/custom.js')
        ]);
        
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        
        $this->loadMigrationsFrom($sourceMigration);
    }
}
