<?php

/**
 * Application Routes:
 *
 * Here is where you can register all of the routes for an application. It's a breeze.
 * Simply tell Laravel the URIs it should respond to and give it the controller to
 * call when that URI is requested.
 *
 * @name       routes.php
 * @category   Routes
 * @package    Routes
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
Route::group(['middleware' => ['web'], 'namespace' => 'Modules\@USample@\Controllers'], function () {
    Route::get('@LSample@/list', [
        'as'   => '@LSample@.index',
        'uses' => '@USample@Controller@index'
    ]);
    Route::post('@LSample@/list', [
        'as'   => '@LSample@.search',
        'uses' => '@USample@Controller@index'
    ]);
    Route::post('@LSample@/create', [
        'as'   => '@LSample@.create',
        'uses' => '@USample@Controller@create'
    ]);
    Route::get('@LSample@/create', [
        'as'   => '@LSample@.create',
        'uses' => '@USample@Controller@create'
    ]);
    Route::get('@LSample@/show/{id}', [
        'as'   => '@LSample@.show',
        'uses' => '@USample@Controller@show'
    ]);
    Route::get('@LSample@/{id}/edit', [
        'as'   => '@LSample@.edit',
        'uses' => '@USample@Controller@edit'
    ]);
    Route::put('@LSample@/{id}', [
        'as'   => '@LSample@.update',
        'uses' => '@USample@Controller@update'
    ]);
    Route::delete('@LSample@/{id}', [
        'as'   => '@LSample@.destroy',
        'uses' => '@USample@Controller@destroy'
    ]);
    Route::get('@LSample@/getList', [
        'as'   => '@LSample@.getJsonList',
        'uses' => '@USample@Controller@getJsonList'
    ]);
});
