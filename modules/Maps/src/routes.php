<?php

/**
 * Routes is using for urls and namespace used for give path for controller
 *
 * @name       routes.php
 * @category   Route
 * @package    Maps
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
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
    
    'namespace' => 'Modules\Maps\Controller'
], function () {
    
    // route for Maps home page
    Route::get('maps/worldmap','MapsController@showWorldMap'); 
    Route::post('maps/worldmap','MapsController@showWorldMap');
    Route::get('maps/personalmap','MapsController@showPersonalMap');  
    Route::post('maps/personalmap','MapsController@showPersonalMap');
    Route::get('maps/getLatsLong','MapsController@getLatLongs');   
    
});
