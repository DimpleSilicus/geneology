<?php

/**
 *  This is a base EventServiceProvider file provided by Laravel
 *
 * @name       EventServiceProvider
 * @category   EventServiceProvider
 * @package    EventServiceProvider
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 0a3db67137630deba8aad17ebe631f3796a585f9 $
 * @link       None
 * @filesource
 */

namespace App\Providers;

//use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * This is a base EventServiceProvider Class provided by Laravel
 *
 * @name     EventServiceProvider
 * @category EventServiceProvider
 * @package  EventServiceProvider
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

}
