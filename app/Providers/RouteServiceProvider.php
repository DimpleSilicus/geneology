<?php

/**
 *  This is a base RouteServiceProvider file provided by Laravel
 *
 * @name       RouteServiceProvider
 * @category   RouteServiceProvider
 * @package    RouteServiceProvider
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 57ee1b03811a5136e27a358f117448f2c544cd7d $
 * @link       None
 * @filesource
 */

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * This is a base RouteServiceProvider Class provided by Laravel
 *
 * @name     RouteServiceProvider
 * @category RouteServiceProvider
 * @package  RouteServiceProvider
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group(['namespace' => $this->namespace, 'middleware' => 'web',], function ($router) {
            include app_path('Http/routes.php');
        });
    }

}
