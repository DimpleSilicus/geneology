<?php

/**
 *  This is a base RedirectIfAuthenticated file provided by Laravel
 *
 * @name       RedirectIfAuthenticated
 * @category   RedirectIfAuthenticated
 * @package    RedirectIfAuthenticated
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: e42c7046ce0c7e7c8b78fc060fe27d7b9dbd56af $
 * @link       None
 * @filesource
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * This is a base RedirectIfAuthenticated Class provided by Laravel
 *
 * @name RedirectIfAuthenticated
 * @category RedirectIfAuthenticated
 * @package RedirectIfAuthenticated
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class RedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *            Request
     * @param \Closure $next
     *            Closure
     * @param string|null $guard
     *            Guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->isAdmin()) {
            return redirect('/admin/dashboard');
        } elseif (Auth::guard($guard)->check() && ! Auth::user()->isAdmin() && \Route::current()->action['prefix'] == 'admin') {
            return redirect('/profiles/mynetwork');
        }
        
        return $next($request);
    }
}
