<?php

/**
 *  This is an administrator control panel
 *
 * @name       DashboardController.php
 * @category   Admin
 * @package    Admin
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 5883b2e0fd6c7f6be2d390d4375ce8582c260cdb $
 * @link       None
 * @filesource
 */

namespace Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Controllers\AdminBaseController;
use App\User;
use App\Profile;

/**
 * This is an administrator control panel
 *
 * @name     DashboardController
 * @category Admin
 * @package  Admin
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class DashboardController extends AdminBaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Admin can view and change his/her profile details
     *
     * @name   showProfileForm
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function showProfileForm()
    {
        $jsFiles[] = $this->url . '/theme/' . $this->adminTheme . '/js/profile.js';
        $jsFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->adminTheme . '/js/moment.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->adminTheme . '/js/fileinput.min.js';

        $cssFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css';
        $cssFiles[] = $this->url . '/theme/' . $this->adminTheme . '/css/fileinput.min.css';
        $cssFiles[] = $this->url . '/theme/' . $this->adminTheme . '/css/profile.css';

        $this->loadJsCSS($jsFiles, $cssFiles);

        $id          = auth()->user()->id;
        $userDetails = User::getInfo($id);

        return view('Admin::profile', compact('id', 'userDetails'));
    }

    /**
     * Admin can view and change his/her profile details
     *
     * @name   updateProfile
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param obj $request request object to validate
     *
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $userId = $request->pk;

        if ($request->name == 'username' || $request->name == 'status' || $request->name == 'email') {
            $request->name = $request->name == 'username' ? 'name' : $request->name;
            User::saveProfile($request->name, $request->value, $userId);
        } else {
            Profile::saveProfile($request->name, $request->value, $userId);
        }
        return;
    }

    /**
     * Admin can view and change his/her password details
     *
     * @name   changePasswordForm
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function changePasswordForm()
    {
        return view('Admin::change-password');
    }

    /**
     * User can chnage his/her password
     *
     * @name   changePassword
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param Request $request Request details
     *
     * @return void
     */
    public function changeMyPassword(Request $request)
    {
        $isValidated = $this->_changePasswordValidation($request);

        if (!$isValidated) {
            $message = 'The specified password does not match the database password';
            return view('Admin::change-password', compact('message'));
        }

        $response = User::savePassword($request);
        $message  = $response ? 'Your password has been reset successfully!' : 'Seems there is a technical issue please try after some time';

        return view('Admin::change-password', compact('message'));
    }

    /**
     * Validation rules for change password
     *
     * @name   _changePasswordValidation
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param Request $request Request details
     *
     * @return void
     */
    private function _changePasswordValidation(Request $request)
    {
        $this->validate($request, [
            'old_password'          => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

        $data = $request->all();
        $user = User::find(auth()->user()->id);
        if (\Hash::check($data['old_password'], $user->password)) {
            return 1;
        } else {
            return 0;
        }
    }

}
