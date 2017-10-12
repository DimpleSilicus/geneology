<?php

/**
 *  This is a base Authenticate file provided by Laravel
 *
 * @name       Authenticate
 * @category   Authenticate
 * @package    Authenticate
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: ecd8b4e8a846b9185ece88dd641deb66d6c1b1f6 $
 * @link       None
 * @filesource
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * This is a base Authenticate Class provided by Laravel
 *
 * @name Authenticate
 * @category Authenticate
 * @package Authenticate
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class Authenticate
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
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                if ($request->route()->getPrefix() === 'admin') {
                    return redirect()->guest('admin/login');
                } else {
                    return redirect()->guest('/');
                }
            }
        }else {
            if (Auth::guard($guard)->check() && Auth::user()->isAdmin()) {
            } elseif (Auth::guard($guard)->check() && !Auth::user()->isAdmin() && $request->route()->getPrefix() == 'admin') {

                return redirect('/profiles/mynetwork');
            }
        }
        
        return $next($request);
    }
}
