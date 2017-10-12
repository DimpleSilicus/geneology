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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Pages\Model\PageCategory;
use Modules\Pages\Model\Page;
use Illuminate\Support\Facades\Config;
use Modules\Admin\Controllers\AdminBaseController;

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
class PagesController extends AdminBaseController
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
	
	public function aboutGNH()
    {
	return view('pages::index');
	}

    /**
     *  Displays page listing
     *
     * @name   index
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function index()
    {
        $jsFiles[]        = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js";
        $jsFiles[]        = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js";
        $jsFiles[]        = "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js";
        $jsFiles[]        = $this->url . '/theme/' . $this->adminTheme . '/js/datagrid.js';
        $jsFiles[]        = "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js";
        $jsFiles[]        = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js";
        $jsFiles[]        = $this->url . '/theme/' . $this->adminTheme . '/assets/tinymce/tinymce.min.js';
        $jsFiles[]        = $this->url . '/theme/' . $this->adminTheme . '/assets/pages/js/pages.js';
        $cssFiles[]       = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css";
        $cssFiles[]       = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css";
        $cssFiles[]       = "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css";
        $this->loadJsCSS($jsFiles, $cssFiles);
        $metadata         = ['title' => 'Page List'];
        $this->addMetadata($metadata);
        $userId           = Auth::id();
        $pageCategoryList = PageCategory::getAllActivePageCategories($userId);
        return view('pages::page')->with('pageCategoryList', $pageCategoryList);
    }

    /**
     *  Get page listing
     *
     * @name   getList
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param $request request $request object to validate
     *
     * @return void
     */
    public function getList(Request $request)
    {
        $columns             = ['name', 'meta_title', 'slug', 'publish', 'preview', 'edit', 'delete'];   // List of columns (field name) those are sortable and searchable
        $filter['search']    = $request->input('search')['value'];
        $filter['start']     = $request->input('start');
        $filter['length']    = $request->input('length');
        $filter['sortBy']    = $columns[$request->input('order')[0]['column']];
        $filter['sortOrder'] = $request->input('order')[0]['dir'];
        $userId              = Auth::id();
        $list                = Page::getAllPages($filter);
        $total               = Page::getPageCount($filter);
        $result              = ["draw" => uniqid(), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $list];
        return response()->json($result);
    }

    /**
     *  Edit page
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
        $jsFiles[]        = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js";
        $jsFiles[]        = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js";
        $jsFiles[]        = "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js";
        $jsFiles[]        = $this->url . '/theme/' . $this->adminTheme . '/js/datagrid.js';
        $jsFiles[]        = "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js";
        $jsFiles[]        = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js";
        $jsFiles[]        = $this->url . '/theme/' . $this->adminTheme . '/assets/tinymce/tinymce.min.js';
        $jsFiles[]        = $this->url . '/theme/' . $this->adminTheme . '/assets/pages/js/pages.js';
        $cssFiles[]       = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css";
        $cssFiles[]       = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css";
        $cssFiles[]       = "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css";
        $this->loadJsCSS($jsFiles, $cssFiles);
        $metadata         = ['title' => 'Edit Page'];
        $this->addMetadata($metadata);
        $userId           = Auth::id();
        $pageDetails      = Page::find($id);
        $pageCategoryList = PageCategory::getAllActivePageCategories($userId);
        return view('pages::page')->with('pageDetails', $pageDetails)->with('pageCategoryList', $pageCategoryList);
    }

    /**
     * This will saves the page into database.
     *
     * @name   savePage
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param obj $request request object to validate
     *
     * @return void
     */
    public function savePage(Request $request)
    {
        $this->validate($request, [
            'name'            => 'required',
            'slug'            => 'required',
            'metaTitle'       => 'required',
            'metaKeyword'     => 'required',
            'metaDescription' => 'required',
            'pageCategoryId'  => 'required|numeric|min:1',
        ]);
        $userId  = Auth::id();
        $addPage = Page::savePageDetails($request, $userId);
        $message = $request->id != '' ? 'updated' : 'saved';
        return redirect('/admin/pages/list')->with('successMessage', 'Page ' . $message . ' successfully');
    }

    /**
     * This will delete : sets status to 2 of the page from the database.
     *
     * @name   delete
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $request - of a page which you want to delete
     *
     * @return void
     */
    public function delete(Request $request)
    {
        $id         = $request->id;
        $deletePage = Page::deletePage($id);
        return redirect('/admin/pages/list')->with('successMessage', 'Page deleted successfully');
    }

    /**
     * This will change the page status the page into database.
     *
     * @name   updatePageStatus
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param obj $request request object to validate
     *
     * @return void
     */
    public function updatePageStatus(Request $request)
    {
        $userId       = Auth::id();
        $updateStatus = Page::updateStatus($request, $userId);
        return response()->json($updateStatus);
    }

}
