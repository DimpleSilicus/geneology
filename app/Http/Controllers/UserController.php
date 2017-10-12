<?php

/**
 *  This file handle user profile as well as change password functionality
 *
 * @name       UserController.php
 * @category   User
 * @package    Controller
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: da75e564ffb4f7fd67bad71778009e8c02067ce9 $
 * @link       None
 * @filesource
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\Hash;
use mikehaertl\wkhtmlto\Pdf;
use Modules\ToolKit\PDFTemplates;

/**
 * This class handle user profile as well as change password functionality
 *
 * @name     UserController
 * @category Controller
 * @package  User
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class UserController extends Controller
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
     * User can view and chnage his/her profile details
     *
     * @name   showProfileForm
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function showProfileForm()
    {
        $metadata = ['title' => 'Profile', 'description' => 'Profile', 'keywords' => 'Profile'];
        $this->addMetadata($metadata);

        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/user.js';
        $jsFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/moment.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->theme . '/js/fileinput.min.js';

        $cssFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css';
        $cssFiles[] = $this->url . '/theme/' . $this->theme . '/css/fileinput.min.css';
        $cssFiles[] = $this->url . '/theme/' . $this->theme . '/css/profile.css';

        $this->loadJsCSS($jsFiles, $cssFiles);

        $userDetails = User::getInfo();

        return view($this->theme . '.user.profile', compact('userDetails'));
    }

    /**
     * User can view and chnage his/her profile details
     *
     * @name   showProfileForm
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param obj $request request object to validate
     *
     * @return void
     */
    public function updateProfile(Request $request)
    {
        if ($request->name == 'username') {
            User::saveProfile('name', $request->value);
        } else {
            Profile::saveProfile($request->name, $request->value);
        }
        return;
    }

    /**
     * User can chnage his/her password
     *
     * @name   changePasswordForm
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param Request $request Request details
     *
     * @return void
     */
    public function changePasswordForm(Request $request)
    {
        $metadata = ['title' => 'Change Password', 'description' => 'Change Password', 'keywords' => 'Change Password'];
        $this->addMetadata($metadata);

        return view($this->theme . '.user.change_password');
    }

    /**
     * User can chnage his/her password
     *
     * @name   changePassword
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
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
            return view($this->theme . '.user.change_password', compact('message'));
        }

        $metadata = ['title' => 'Change Password', 'description' => 'Change Password', 'keywords' => 'Change Password'];
        $this->addMetadata($metadata);

        $response = User::savePassword($request);
        $message  = $response ? 'Your password has been reset successfully!' : 'Seems there is a technical issue please try after some time';

        return view($this->theme . '.user.change_password', compact('message'));
    }

    /**
     * User dashboard screen
     *
     * @name   dashboard
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function dashboard()
    {
        $metadata = ['title' => 'Dashboard', 'description' => 'Dashboard', 'keywords' => 'Dashboard'];
        $this->addMetadata($metadata);

        return view($this->theme . '.user.dashboard');
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
        if (Hash::check($data['old_password'], $user->password)) {
            return 1;
        } else {
            return 0;
        }
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
    public function updateAvatar(Request $request)
    {

        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {

            $uploadDirectory = public_path() . '/profile/';

            //Is file size is less than allowed size.
            if ($_FILES["avatar"]["size"] > 5242880) {
                return '<div id="filesMessage">File size is too big!</div>';
            }

            //allowed file type Server side check
            switch (strtolower($_FILES['avatar']['type'])) {
                //allowed file types
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                    break;
                default:
                    return '<div id="filesMessage">Unsupported File!</div>';
            }

            $fileName     = strtolower($_FILES['avatar']['name']);
            $fileExt      = substr($fileName, strrpos($fileName, '.')); //get file extention
            $userId       = \Auth::user()->id;
            $randomNumber = md5($userId); //Random number to be added to name.
            $newFileName  = $randomNumber . $fileExt; //new file name

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDirectory . $newFileName)) {
                Profile::saveProfile('avatar', $newFileName);
                return '<div id="filesMessage">Success! File Uploaded.</div>';
            } else {
                return '<div id="filesMessage">error uploading File!</div>';
            }
        } else {
            return '<div id="filesMessage">Please upload file.</div>';
        }
    }

    /**
     * To download pdf
     *
     * @name   downloadPDf
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function downloadPDf()
    {
        $user            = User::find(auth()->user()->id);
        $name            = $user->name;
        $date            = date('d M Y');
        $courseTitle     = 'PHP 7.0.0';
        $numberOfHours   = 2;
        $templateId      = 1;
        $data            = array ('name' => $name, 'date' => $date, 'course_title' => $courseTitle, 'number_of_hours' => $numberOfHours);
        $templateDetails = PDFTemplates::makePDF($templateId, $data);
    }

}
