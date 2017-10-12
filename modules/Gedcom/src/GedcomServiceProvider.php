<?php

/**
 * GedcomServiceProvider service provider for .
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
namespace Modules\Gedcom;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * GedcomServiceProvider for publish images, css, js
 *
 * @name GedcomServiceProvider
 * @category ServiceProvider
 * @package Gedcom
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class GedcomServiceProvider extends ServiceProvider
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
        $this->app->bind('Gedcom', function ($app) {
            return new Gedcom();
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
        $this->loadViewsFrom(__DIR__ . '/Views/', 'Gedcom');
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        $sourceSeeds = realpath(__DIR__ . '/../Seeds');
        
        $this->loadMigrationsFrom($sourceMigration);
        // For js
        $sourceJs = realpath(__DIR__ . '/../public/js');
        
        $this->publishes([
            $sourceJs => base_path('public/theme/' . $theme . '/assets/gedcom/js/'),
            $sourceSeeds => database_path('seeds')
        ]);
        
        // include route file of this package
        include __DIR__ . '/routes.php';
    }
}
