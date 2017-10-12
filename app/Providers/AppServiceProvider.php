<?php

/**
 *  Laravel AppServiceProvider file
 *
 * @name       AppServiceProvider.php
 * @category   Providers
 * @package    Providers
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: bc34ed3110b973b33b9aaf72a1c2fafcbd29aff8 $
 * @link       None
 * @filesource
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Laravel default AppServiceProvider class
 *
 * @name     AppServiceProvider
 * @category Providers
 * @package  Providers
 * @author   Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  Release:<v.1>
 * @link     None
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @name   boot
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function boot()
    {

        /* Get and make global shmart merchant site URL */
        $siteUrl = config('app.url');
        view()->share('url', $siteUrl);

        /* Get and make global CMS theme */
        $theme = config('app.theme');
        view()->share('theme', $theme);

        /* Get and make global CMS theme */
        $adminTheme = config('app.adminTheme');
        view()->share('adminTheme', $adminTheme);

        /* Get and make css cache enabled  */
        $cssCacheEnabled = config('app.css_cache_enabled');
        view()->share('cssCacheEnabled', $cssCacheEnabled);

        /* Get and make js cache enabled  */
        $jsCacheEnabled = config('app.js_cache_enabled');
        view()->share('jsCacheEnabled', $jsCacheEnabled);

        /* Set time stamp for JS  */
        view()->share('jsTimeStamp', $jsCacheEnabled ? '?t=' . time() : '');

        /* Set time stamp for CSS */
        view()->share('cssTimeStamp', $cssCacheEnabled ? '?t=' . time() : '');
    }

    /**
     * Register any application services.
     *
     * @name   boot
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function register()
    {

    }

}
