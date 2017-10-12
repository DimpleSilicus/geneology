<?php

/**
 * UserServiceProvider class to add / edit / delete users
 *
 * @name       UserServiceProvider.php
 * @category   Contacts
 * @package    Backup
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 753130cdf08b0bf1e868b7ad84662cecc137bb2f $
 * @link       None
 * @filesource
 */
namespace Modules\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * UserServiceProvider class
 *
 * @name UserServiceProvider.php
 * @category User
 * @package User
 * @author Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license Silicus http://www.silicus.com/
 * @version GIT: $Id: 753130cdf08b0bf1e868b7ad84662cecc137bb2f $
 * @link None
 * @filesource
 *
 */
class UserServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @name register
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('User', function ($app) {
            return new User();
        });
    }

    /**
     * This will perform post-registration booting of services.
     *
     * @name register
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
        // loading the routes files
        include __DIR__ . '/routes.php';
        
        // define the path to view files
        $this->loadViewsFrom(__DIR__ . '/Views', 'user');
        
        $theme = Config::get('app.theme');
        
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        
        $this->loadMigrationsFrom($sourceMigration);
    }
}
