<?php

/**
 * This middleware run before stat of all other middleware.
 *
 * @name       BeforeMiddleware
 * @category   Middleware
 * @package    Middleware
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 3e174a958939bf8281ffe4ec5849dab34310721f $
 * @link       None
 * @filesource
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

/**
 * This middleware run before start of all other middleware.
 *
 * @name     BeforeMiddleware
 * @category Middleware
 * @package  Middleware
 * @author   Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  Release:<v.1>
 * @link     None
 */
class BeforeMiddleware
{

    /**
     * This is a default laravel handler
     *
     * @name   handle
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $request Page request
     * @param string $next    Page next action
     *
     * @return void
     */
    public function handle($request, Closure $next)
    {
        if (\Config::get('app.queryLog') == true) {
            DB::connection('mysql')->enableQueryLog();
        }
        return $next($request);
    }

}
