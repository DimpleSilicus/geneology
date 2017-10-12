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
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 9cb59cbefd774dbdd59e04fc710d4320b81f73d4 $
 * @link       None
 * @filesource
 */
use Modules\Pages\Model\Page;

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'namespace' => 'Modules\Pages\Controllers'], function () {
    Route::get('/pages/list', 'PagesController@index');
    Route::get('/pages/getList', 'PagesController@getList');
    Route::post('/pages/savePage', 'PagesController@savePage');
    Route::post('/pages/updatePageStatus', 'PagesController@updatePageStatus');
    Route::post('/pages/delete', 'PagesController@delete');
    Route::get('/pages/edit/{id}', 'PagesController@edit');
    Route::get('/pages/category/list', 'PageCategoryController@index');
    Route::get('/pages/category/getCategoryList', 'PageCategoryController@getCategoryList');
    Route::post('/pages/savePageCategory', 'PageCategoryController@savePageCategory');
    Route::get('/pages/category/edit/{id}', 'PageCategoryController@edit');
    Route::post('/pages/category/delete', 'PageCategoryController@delete');
});

Route::group(['middleware' =>['guest'], 'namespace' => 'Modules\Pages\Controllers'], function () {
    Route::get('/about-gnh', 'PagesController@aboutGNH');
});

Route::get('{slug}', function ($slug) {
    $page        = Page::where('slug', $slug)->where('publish', '1');
    $pageDetails = $page->firstOrFail();
    return view('pages::slug')->with('pageDetails', $pageDetails);
});
