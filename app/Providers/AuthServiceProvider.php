<?php

/**
 *  This is a base AuthServiceProvider file provided by Laravel
 *
 * @name       AuthServiceProvider
 * @category   AuthServiceProvider
 * @package    AuthServiceProvider
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 33a53028fe1cc136581eedf3cdc254a9894aac4c $
 * @link       None
 * @filesource
 */

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * This is a base AuthServiceProvider Class provided by Laravel
 *
 * @name     AuthServiceProvider
 * @category AuthServiceProvider
 * @package  AuthServiceProvider
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate GateContract
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }

}
