<?php

/**
 * Routes is using for urls and namespace used for give path for controller
 *
 * @name       routes
 * @category   Module
 * @package    ActivityLog
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'namespace' => 'Modules\ActivityLog\Controller'], function () {
    Route::get('activity-log', 'ActivityLogController@view');
    Route::post('activity-log', 'ActivityLogController@view');
    Route::get('activity-log/getList/{duration}', 'ActivityLogController@activityLogJsonList');
});
