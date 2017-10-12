<?php

/**
 * MyAppsServiceProvider service provider for publish images, css and js.
 *
 * @name       MyAppsServiceProvider
 * @category   Module
 * @package    Profile
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\MyApps;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * MyAppsServiceProvider for publish images, css, js
 *
 * @name MyAppsServiceProvider
 * @category ServiceProvider
 * @package Activitylog
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class MyAppsServiceProvider extends ServiceProvider
{

    /**
     * For register our service provider
     *
     * @name register
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MyApps', function ($app) {
            return new MyApps();
        });
    }

    /**
     * This function is for send migration files in migration folder
     *
     * @name boot
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
        // get theme name
        $theme = Config::get('app.theme');
        
        // set theme path
        $this->loadViewsFrom(__DIR__ . '/Views/', 'MyApps');
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        // $this->publishes([$sourceMigration => database_path('migrations')]);
        $this->loadMigrationsFrom($sourceMigration);
        // For js
        $sourceJs = realpath(__DIR__ . '/../public/js');
		
        
        $this->publishes([
            $sourceJs => base_path('public/theme/' . $theme . '/assets/myapps/js/')
        ]);
        
        // include route file of this package
        include __DIR__ . '/routes.php';
    }
}
