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

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Controllers\AdminBaseController;
use App\User;
use App\Profile;

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
class UserAdminController extends AdminBaseController
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
     * @name   userViewList
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function userViewList()
    {
        $metadata = ['title' => 'User List', 'description' => 'User List', 'keywords' => 'Users'];
        $this->addMetadata($metadata);

        $jsFiles[] = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.3/js/bootstrap-dialog.min.js';
        $jsFiles[] = 'https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js';
        $jsFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js';
        $jsFiles[] = $this->url . '/theme/' . $this->adminTheme . '/js/moment.min.js';
        $jsFiles[] = 'https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.js';
        $jsFiles[] = $this->url . '/theme/' . $this->adminTheme . '/js/user.js';

        $cssFiles[] = 'https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css';
        $cssFiles[] = 'https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css';
        $cssFiles[] = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.3/css/bootstrap-dialog.min.css';
        $cssFiles[] = '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css';


        $this->loadJsCSS($jsFiles, $cssFiles);
        return view('user::admin.list');
    }

    /**
     * Get user list in json format
     *
     * @name   userJsonList
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param Object $request a
     *
     * @return void
     */
    public function userJsonList(Request $request)
    {
        $columns = ['name', 'email', 'created_at', 'status'];   // List of columns (field name) those are sortable and searchable

        $filter['search']    = $request->input('search')['value'];
        $filter['start']     = $request->input('start');
        $filter['length']    = $request->input('length');
        $filter['sortBy']    = $columns[$request->input('order')[0]['column']];
        $filter['sortOrder'] = $request->input('order')[0]['dir'];

        $userList = User::getAllUsersForListing($filter);
        $total    = User::getUserCount($filter);
        $result   = ["draw" => uniqid(), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $userList];

        return response()->json($result);
    }

    /**
     * Delete user
     *
     * @name   userJsonList
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param Object $request a
     *
     * @return void
     */
    public function deleteUser(Request $request)
    {
        $result = User::deleteUser($request['id']);
        return response()->json($result);
    }

    /**
     * Get user details
     *
     * @name   getUserDetails
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param int $id User ID
     *
     * @return void
     */
    public function getUserDetails($id)
    {
        $result = User::getInfo($id);
        return view('user::admin.details')->with('result', $result);
    }

    /**
     * Edit user details
     *
     * @name   editUserDetails
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param int $id User ID
     *
     * @return void
     */
    public function editUserDetails($id)
    {
        $result = User::getInfo($id);
        return view('user::admin.editDetails', compact(['result', 'id']));
    }

}
