<?php

/**
 *  This is a base broadcasting file provided by Laravel
 *
 * @name       broadcasting
 * @category   Configuration
 * @package    Configuration
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
return [

    /*
      |--------------------------------------------------------------------------
      | Default Broadcaster
      |--------------------------------------------------------------------------
      |
      | This option controls the default broadcaster that will be used by the
      | framework when an event needs to be broadcast. You may set this to
      | any of the connections defined in the "connections" array below.
      |
     */

    'default'     => env('BROADCAST_DRIVER', 'pusher'),
    /*
      |--------------------------------------------------------------------------
      | Broadcast Connections
      |--------------------------------------------------------------------------
      |
      | Here you may define all of the broadcast connections that will be used
      | to broadcast events to other systems or over websockets. Samples of
      | each available type of connection are provided inside this array.
      |
     */
    'connections' => [

        'pusher' => [
            'driver'  => 'pusher',
            'key'     => env('PUSHER_KEY'),
            'secret'  => env('PUSHER_SECRET'),
            'app_id'  => env('PUSHER_APP_ID'),
            'options' => [
            //
            ],
        ],
        'redis'  => [
            'driver'     => 'redis',
            'connection' => 'default',
        ],
        'log'    => [
            'driver' => 'log',
        ],
    ],
];
