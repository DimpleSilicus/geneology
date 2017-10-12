<?php

/**
 *  This is a base VerifyCsrfToken file provided by Laravel
 *
 * @name       VerifyCsrfToken
 * @category   VerifyCsrfToken
 * @package    VerifyCsrfToken
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

/**
 * This is a base VerifyCsrfToken Class provided by Laravel
 *
 * @name     VerifyCsrfToken
 * @category VerifyCsrfToken
 * @package  VerifyCsrfToken
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class VerifyCsrfToken extends BaseVerifier
{

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
            //
    ];

}
