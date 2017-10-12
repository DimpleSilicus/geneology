<?php

/**
 *  Faq Controller file
 *
 * @name       FaqAdminController.php
 * @category   Controller
 * @package    Faq
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\Faq\Controllers;

use Modules\Admin\Controllers\AdminBaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Modules\Faq\Faq;

/**
 *  Faq Controller class
 *
 * @name     FaqAdminController
 * @category Controller
 * @package  Faq
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class FaqAdminController extends AdminBaseController
{

    /**
     * Constructor call
     */
    public function __construct()
    {
        parent::__construct();
        $metadata = ['title' => 'FAQ', 'description' => 'FAQ', 'keywords' => 'FAQ, lists, create, edit'];
        $this->addMetadata($metadata);
    }

    /**
     * List of faqs
     *
     * @name   index
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @param DataType $request description
     *
     * @return void
     */
    public function index(Request $request)
    {
        $input      = $request->all();
        $searchTerm = trim($request->get('query'));
        if ($searchTerm) {
            $faq = Faq::searchByAll($searchTerm);
        } else {
            $faq = Faq::paginateRecords();
        }

        $data = $this->addJsCss();

        $this->loadJsCSS($data['jsFiles'], $data['cssFiles']);
        return view('Faq::index')->with(['faq' => $faq]);
    }

    /**
     * List Faq
     *
     * @name   listFaq
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @param DataType $request description
     *
     * @return void
     */
    public function listFaq(Request $request)
    {
        $input      = $request->all();
        $searchTerm = trim($request->get('query'));
        if ($searchTerm) {
            $faq = Faq::searchByAll($searchTerm);
        } else
            $faq = Faq::paginateRecords();

        $data = $this->addJsCss();

        $this->loadJsCSS($data['jsFiles'], $data['cssFiles']);
        return view('Faq::list-faq')->with(['faq' => $faq]);
    }

    /**
     * Show the form for creating a new Faq.
     *
     * @return Response
     */
    public function create()
    {
        $data = $this->addJsCss();
        $this->loadJsCSS($data['jsFiles'], $data['cssFiles']);
        return view('Faq::create');
    }

    /**
     * Store a newly created Faq in database.
     *
     * @return Response
     */
    public function store()
    {

        $input      = Input::all();
        $validation = Validator::make($input, Faq::$rules);
        if ($validation->passes()) {
            Faq::createRecord($input);
            return Redirect::route('faq.index')->withInput()->with('successMessage', 'Faq created successfully.');
        }

        return Redirect::route('faq.create')
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function show($id)
    {
        $faq = Faq::find($id);
        return view('Faq::detail', compact('faq'));
    }

    /**
     * Show the form for editing the specified Faq.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function edit($id)
    {
        $faq = Faq::find($id);
        if (is_null($faq)) {
            return Redirect::route('faq.index');
        }
        $data = $this->addJsCss();
        $this->loadJsCSS($data['jsFiles'], $data['cssFiles']);
        return view('Faq::edit', compact('faq'));
    }

    /**
     * Update the specified Faq in database.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function update($id)
    {
        $input    = Input::except("status");
        $inputAll = Input::all();

        if (null == Input::get("status")) {
            $inputAll["status"] = 0;
        } else {
            $inputAll["status"] = 1;
        }
        $validation = Validator::make($input, Faq::$rules);

        if ($validation->passes()) {
            Faq::updateRecord($id, $inputAll);
            return Redirect::route('faq.index', $id)->withInput()->with('successMessage', 'Faq updated successfully.');
        }
        return Redirect::route('faq.edit', $id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    /**
     * Update the specified Faq in database.
     *
     * @param Request $request access request params
     *
     * @return Response
     */
    public function updateStatus(Request $request)
    {
        $input    = $request->except("status");
        $inputAll = $request->all();
        Faq::updateRecord($request->id, $inputAll);
        return 'success';
    }

    /**
     * Remove the specified Faq from database.
     *
     * @param Request $request access request params
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        //It's hard delete
        Faq::deleteRecord($request->id);
        //return Redirect::route('faq.index')->withInput()->with('successMessage', 'Faq deleted successfully.');
    }

    /**
     * To add js and css files required
     *
     * @name   addJsCss
     * @access public
     * @return void
     */
    public function addJsCss()
    {

        $jsFiles[]  = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js";
        $jsFiles[]  = $this->url . 'theme/' . $this->adminTheme . '/assets/faq/js/bootstrap-dialog.min.js';
        $jsFiles[]  = $this->url . '/theme/' . $this->adminTheme . '/assets/faq/js/faq.js';
        //$jsFiles[]  = $this->url . '/theme/' . $this->adminTheme . '/js/datagrid.js';
        $cssFiles[] = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css";
        $cssFiles[] = "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css";
        $cssFiles[] = $this->url . 'theme/' . $this->adminTheme . '/assets/faq/css/bootstrap-dialog.min.css';
        $this->loadJsCSS($jsFiles, $cssFiles);
    }

    /**
     * Get faq list in json format
     *
     * @name   faqJsonList
     * @access public
     * @author Prasad Nanaware <prasad.nanaware@silicus.com>
     *
     * @param Object $request a
     *
     * @return void
     */
    public function faqJsonList(Request $request)
    {
        $columns = ['question', 'answer', 'status', 'id as edit', 'id as delete'];   // List of columns (field name) those are sortable and searchable

        $filter['search']    = $request->input('search')['value'];
        $filter['start']     = $request->input('start');
        $filter['length']    = $request->input('length');
        $filter['sortBy']    = $columns[$request->input('order')[0]['column']];
        $filter['sortOrder'] = $request->input('order')[0]['dir'];

        $list   = Faq::getAllFaq($filter);
        $total  = Faq::getFaqCount($filter);
        $result = ["draw" => uniqid(), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $list];

        return response()->json($result);
    }

}
