<?php

/**
 *  This is a base EncryptCookies file provided by Laravel
 *
 * @name       EncryptCookies
 * @category   EncryptCookies
 * @package    EncryptCookies
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * This is a base EncryptCookies Class provided by Laravel
 *
 * @name     EncryptCookies
 * @category EncryptCookies
 * @package  EncryptCookies
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class EncryptCookies extends BaseEncrypter
{

    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
            //
    ];

}
