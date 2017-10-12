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
Route::group(['middleware' => ['web'], 'namespace' => 'Modules\Faq\Controllers'], function () {
    Route::get('faqs', [
        'as'   => 'faq.index',
        'uses' => 'FaqController@listFaq'
    ]);
});
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'namespace' => 'Modules\Faq\Controllers'], function () {
    Route::get('faqs', [
        'as'   => 'faq.index',
        'uses' => 'FaqAdminController@index'
    ]);
    Route::get('faqs/getList', [
        'as'   => 'faq.getList',
        'uses' => 'FaqAdminController@faqJsonList'
    ]);
    Route::post('faqs', [
        'as'   => 'faq.search',
        'uses' => 'FaqAdminController@index'
    ]);
    Route::post('faqs/store', [
        'as'   => 'faq.store',
        'uses' => 'FaqAdminController@store'
    ]);
    Route::get('faq/create', [
        'as'   => 'faq.create',
        'uses' => 'FaqAdminController@create'
    ]);
    Route::get('faq/show/{id}', [
        'as'   => 'faq.show',
        'uses' => 'FaqAdminController@show'
    ]);
    Route::get('faq/{id}/edit', [
        'as'   => 'faq.edit',
        'uses' => 'FaqAdminController@edit'
    ]);
    Route::put('faq/{id}', [
        'as'   => 'faq.update',
        'uses' => 'FaqAdminController@update'
    ]);

    Route::post('faqs/status', [
        'as'   => 'faq.status',
        'uses' => 'FaqAdminController@updateStatus'
    ]);
    Route::post('faqs/delete', [
        'as'   => 'faq.destroy',
        'uses' => 'FaqAdminController@destroy'
    ]);
});
