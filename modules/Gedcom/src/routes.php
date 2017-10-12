<?php

/**
 * Routes is using for urls and namespace used for give path for controller
 *
 * @name       routes
 * @category   Module
 * @package    Gedcom
 * @author     Amol Savat <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
Route::group([
    'middleware' => [
        'web',
        'auth'
    ],
    
    'namespace' => 'Modules\Gedcom\Controller'
], function () {
    Route::get('gedcom/toolbox', 'GedcomController@gedcom');
    Route::post('gedcom/upload', 'GedcomController@uploadGedcom');
    Route::post('gedcom/pepole/add', 'GedcomController@addPepole');
    Route::post('gedcom/pepole/edit', 'GedcomController@editPepole');
    Route::post('gedcom/pepole/update', 'GedcomController@updatePepole');
    Route::post('gedcom/pepole/delete', 'GedcomController@deletePepole');
    Route::post('gedcom/family/add', 'GedcomController@addFamily');
    Route::post('gedcom/family/tree', 'GedcomController@getFamilyTree');
});
