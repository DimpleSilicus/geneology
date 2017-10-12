<?php

/**
 *  Application Routes
 *
 * Here is where you can register all of the routes for an application.
 * It's a breeze. Simply tell Laravel the URIs it should respond to
 * and give it the controller to call when that URI is requested.
 *
 * @name       BeforeMiddleware
 * @category   Middleware
 * @package    Middleware
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 09df4bbc1cab98c5ab5306b0dfbaad22b7cb4ed3 $
 * @link       None
 * @filesource
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/contact-us', 'HomeController@contactUs');
    Route::get('/unauthorized', 'HomeController@unauthorized');
    Route::delete('/unauthorized', 'HomeController@unauthorized');
    Route::post('/contact-us', 'HomeController@submitContactUs');
});
