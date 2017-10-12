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
Route::group(['middleware' => ['web', 'guest'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Controllers'], function () {
    Route::get('/', 'AdminController@adminShowLogin');
    Route::get('login', 'AdminController@adminShowLogin');
    Route::get('/forgotpassword','AdminController@forgotPassword');
});

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Controllers'], function () {
    
    // route for admin dashboard
    Route::get('dashboard', 'AdminController@dashboard');    
    
    // route for manage users by admin
    Route::get('manage-user/list', 'AdminController@showUsers');  // display manage users page
    Route::get('manage-user/userList', 'AdminController@getUserList'); //  display user list details
    Route::post('manage-user/searchUser','AdminController@getSearchUserList');   // route to display search user list
    Route::post('manage-user/updateUserStatus','AdminController@UpdateUserStatus'); // change user status(Active/Deactive)
    
    
    // route for manage tutorial by admin
    Route::get('manage-tutorial/list', 'AdminController@showTutorialList');    //  display tutorial  page
    Route::get('manage-tutorial/tutorialList', 'AdminController@getTutorialsList');    // get tutorial list details
    Route::post('manage-tutorial/search','AdminController@getSearchTutorialList');   // route to display search tutorial list
    Route::post('manage-tutorial/addTutorial','AdminController@saveTutorialDetails'); // add new tutorial 
    Route::get('manage-tutorial/editTutorial', 'AdminController@editTutorial');     // tutorial edit page to get form details
    Route::post('manage-tutorial/updateTutorial', 'AdminController@UpdateTutorialDetails'); // update tutorial details 
    
    // route for admin activity 
    Route::get('change-password', 'AdminController@changePasswordForm'); // route to display admin change password form
    Route::post('change-password', 'AdminController@changeAdminPassword');  // route to change admin passsword 
    Route::get('logout', 'AdminController@adminLogout');                 // route for admin logout
    
    Route::get('profile', 'DashboardController@showProfileForm');
    Route::post('profile/update', 'DashboardController@updateProfile');
    Route::post('/profile/update/avatar', 'UserController@updateAvatar');
    Route::get('reports', 'AdminController@reportExcel');
    Route::get('report-sample', 'AdminController@reportExcelSample');
    Route::get('report-sample1', 'AdminController@reportExcelSampleWithFormula');
    Route::get('report-sample2', 'AdminController@reportExcelSampleWithImage');
    
    //To display Subscription of perticular User. 
    Route::get('manage-user/GetSubscription', 'AdminController@GetSubscription');     // tutorial edit page to get form details
    
});
