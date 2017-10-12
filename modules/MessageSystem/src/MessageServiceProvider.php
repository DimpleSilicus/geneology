<?php

/**
 *  Service provider for MessageSystem
 *
 * @name       MessageServiceProvider
 * @category   ServiceProvider
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\MessageSystem;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * MessageServiceProvider class for initiate module
 *
 * @name MessageServiceProvider
 * @category ServiceProvider
 * @package MessageSystem
 * @author Vivek Bansal <vivek.bansal@silicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class MessageServiceProvider extends ServiceProvider
{

    /**
     * Registering service provider
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
     * Function for initiate module.
     *
     * @name boot
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function boot()
    {
        // loading route file
        include __DIR__ . '/routes.php';
        
        // LOAD VIEW FILES
        $this->loadViewsFrom(__DIR__ . '/Views', 'ms');
        $adminTheme = Config::get('app.adminTheme');
        $theme = Config::get('app.theme');
        // Define files which are going to be published
        $this->publishes([
            realpath(__DIR__ . '/../public/js/admin.js') => public_path('theme/' . $adminTheme . '/assets/MessageSystem/js/admin.js'),
            realpath(__DIR__ . '/../public/css/admin.css') => public_path('theme/' . $adminTheme . '/assets/MessageSystem/css/admin.css'),
            realpath(__DIR__ . '/../public/js/front.js') => public_path('theme/' . $theme . '/assets/MessageSystem/js/front.js'),
            realpath(__DIR__ . '/../public/css/front.css') => public_path('theme/' . $theme . '/assets/MessageSystem/css/front.css')
        ]);
        
        $sourceMigration = realpath(__DIR__ . '/../migrations');
        $this->loadMigrationsFrom($sourceMigration);
    }
}
