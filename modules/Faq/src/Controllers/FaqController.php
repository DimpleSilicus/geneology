<?php

/**
 *  Faq Controller file
 *
 * @name       FaqController.php
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
 * @name     FaqController
 * @category Controller
 * @package  Faq
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class FaqController extends AdminBaseController
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
        } else
            $faq = Faq::paginateRecords();

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
     * Remove the specified Faq from database.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //It's hard delete
        Faq::deleteRecord($id);
        return Redirect::route('faq.index')->withInput()->with('successMessage', 'Faq deleted successfully.');
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

        $jsFiles[]  = $this->url . '/theme/' . $this->adminTheme . '/assets/faq/js/faq.js';
        $cssFiles[] = $this->url . 'theme/' . $this->adminTheme . '/assets/faq/css/faq.css';
        $this->loadJsCSS($jsFiles, $cssFiles);
    }

}
