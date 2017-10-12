<?php

/**
 * Pages class to add / edit / delete Pages
 *
 * @name       Pages.php
 * @category   Controller
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 617aad48ff59b42d2b47fd72bac931e80d0f2e0a $
 * @link       None
 * @filesource
 */

namespace Modules\Pages\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Controllers\AdminBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Pages\Model\PageCategory;
use Illuminate\Support\Facades\Config;

/**
 * Pages class to add / edit / delete Pages
 *
 * @name       Pages.php
 * @category   Controller
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 617aad48ff59b42d2b47fd72bac931e80d0f2e0a $
 * @link       None
 * @filesource
 */
class PageCategoryController extends AdminBaseController
{

    /**
     * Class constructor
     *
     * @name   __construct
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     *  Displays page category listing
     *
     * @name   index
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function index()
    {
        $jsFiles[]  = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js";
        $jsFiles[]  = $this->url . '/theme/' . $this->adminTheme . '/assets/pages/js/page_categories.js';
        $jsFiles[]  = "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js";
        $jsFiles[]  = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js";
        $cssFiles[] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css";
        $cssFiles[] = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css";
        $cssFiles[] = "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css";
        $this->loadJsCSS($jsFiles, $cssFiles);
        $metadata   = ['title' => 'Page Category List'];
        $this->addMetadata($metadata);
        $userId     = Auth::id();
        return view('pages::category');
    }

    /**
     *  Displays page category listing
     *
     * @name   getCategoryList
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param $request request $request object to validate
     *
     * @return void
     */
    public function getCategoryList(Request $request)
    {

        $columns             = ['name', 'status', 'edit', 'delete'];   // List of columns (field name) those are sortable and searchable
        $filter['search']    = $request->input('search')['value'];
        $filter['start']     = $request->input('start');
        $filter['length']    = $request->input('length');
        $filter['sortBy']    = $columns[$request->input('order')[0]['column']];
        $filter['sortOrder'] = $request->input('order')[0]['dir'];
        $userId              = Auth::id();
        $list                = PageCategory::getAllPageCategories($filter);
        $total               = PageCategory::getPageCategoryCount($filter);
        $result              = ["draw" => uniqid(), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $list];
        return response()->json($result);
    }

    /**
     *  Page category to edit
     *
     * @name   edit
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param obj $id id object to validate
     *
     * @return void
     */
    public function edit($id)
    {
        $jsFiles[]           = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js";
        $jsFiles[]           = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js";
        $jsFiles[]           = "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js";
        $jsFiles[]           = $this->url . '/theme/' . $this->adminTheme . '/js/datagrid.js';
        $jsFiles[]           = $this->url . '/theme/' . $this->adminTheme . '/assets/pages/js/page_categories.js';
        $jsFiles[]           = "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js";
        $jsFiles[]           = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js";
        $cssFiles[]          = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css";
        $cssFiles[]          = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css";
        $cssFiles[]          = "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css";
        $this->loadJsCSS($jsFiles, $cssFiles);
        $metadata            = ['title' => 'Edit Page Category List'];
        $this->addMetadata($metadata);
        $userId              = Auth::id();
        $pageCategoryDetails = PageCategory::find($id);
        return view('pages::category')->with('pageCategoryDetails', $pageCategoryDetails);
    }

    /**
     * This will saves the page category into database.
     *
     * @name   savePageCategory
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param obj $request request object to validate
     *
     * @return void
     */
    public function savePageCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $userId  = Auth::id();
        $addPage = PageCategory::savePageCategoryDetails($request, $userId);
        $message = $request->id != '' ? 'updated' : 'saved';
        return redirect('/admin/pages/category/list')->with('successMessage', 'Page Category ' . $message . ' successfully');
    }

    /**
     * This will delete : sets status to 2 of the page from the database.
     *
     * @name   delete
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $request - Request a page which you want to delete
     *
     * @return void
     */
    public function delete(Request $request)
    {
        $id         = $request->id;
        $deletePage = PageCategory::deletePageCategory($id);
        return redirect('/admin/pages/category/list')->with('successMessage', 'Page Category deleted successfully');
    }

}
