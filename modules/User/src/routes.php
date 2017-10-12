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
Route::group([
    'middleware' => [
        'web',
        'guest'
    ],
    'namespace' => 'Modules\User\Controllers'
], function () {
    // Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('user/logout', 'Auth\LoginController@adminLogout');
    
    Route::get('/user/forgotpassword','HomeController@forgotPassword');
	
	Route::get('about-gnh', 'HomeController@aboutGNH');
	Route::get('about/familyhistory','HomeController@familyHistory');
	Route::get('about/app', 'HomeController@aboutAplication');
	Route::get('about/service', 'HomeController@aboutService');
	Route::get('about/contactus', 'HomeController@contactUs');
        
        //Submit contact us page.
        Route::post('page/contact-us', 'HomeController@SubmitContactUs');
        
        //Comming Soon page.
	Route::get('about/comingsoon', 'HomeController@ComingSoon');
    /*
     * Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
     * Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
     * Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
     * Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm ');
     */
    
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    
    Route::get('user/register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('user/register', 'Auth\RegisterController@register');
    
    Route::post('user/GetAmount', 'Auth\RegisterController@GetAmountValue');
    Route::post('user/Paidregister', 'Auth\RegisterController@PaidMemberSignup');
    Route::get('user/paypal', array('as' => 'paypal.status','uses' => 'Auth\RegisterController@getPaymentStatus',));
    Route::get('user/sucessRegister', 'Auth\RegisterController@showSucessPage');
    Route::get('user/VerifyUser', 'Auth\RegisterController@VerifyUser');
    
  
	Route::post('user/UpgradeUserPackage', 'Auth\RegisterController@UpgradeUserPackage');
    Route::get('/', 'Auth\LoginController@showMainPage');
    Route::get('page/contact-us', 'Auth\LoginController@showContactUsPage');
    Route::get('page/services', 'Auth\LoginController@showServicesPage');
    Route::get('page/about-app', 'Auth\LoginController@showAboutAppPage');
    Route::get('page/family-history', 'Auth\LoginController@showFamilyHistoryPage');
});

Route::group([
    'middleware' => [
        'web',
        'auth'
    ],
    'namespace' => 'Modules\User\Controllers'
], function () {
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/dashboard', 'UserController@dashboard');
    Route::get('/profile/view', 'UserController@showProfileForm');
    Route::post('/profile/update', 'UserController@updateProfile');
    Route::post('/profile/update/avatar', 'UserController@updateAvatar');
    Route::get('/change-password', 'UserController@changePasswordForm');
    Route::post('account/updatePassword', 'UserController@changeMyPassword');
    Route::get('/pdf/downloadPDf', 'UserController@downloadPDf');
});

/* Admin panel route for Users */
Route::group([
    'middleware' => [
        'web',
        'auth'
    ],
    'prefix' => 'admin',
    'namespace' => 'Modules\User\Controllers'
], function () {
    Route::get('/users/list', 'UserAdminController@userViewList');
    Route::get('/users/getList', 'UserAdminController@userJsonList');
    Route::post('/users/delete', 'UserAdminController@deleteUser');
    Route::get('/users/details/{id}', 'UserAdminController@getUserDetails');
    Route::get('/users/update/{id}', 'UserAdminController@editUserDetails');
});
