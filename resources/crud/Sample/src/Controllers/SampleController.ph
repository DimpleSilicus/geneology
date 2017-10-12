<?php

/**
 *  @USample@ Controller file
 *
 * @name       @USample@Controller.php
 * @category   Controller
 * @package    @USample@
 * @author     Swati jadhav <swati.jadhav@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\@USample@\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Modules\@USample@\Models\@USample@;

use DB;

/**
 *  @USample@ Controller class
 *
 * @name     @USample@Controller
 * @category Controller
 * @package  @USample@
 * @author   Swati jadhav <swati.jadhav@silicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class @USample@Controller extends Controller
{

    /**
     * Constructor call
     */
    public function __construct()
    {
		parent::__construct();
                $metadata = ['title' => '@USample@', 'description' => '@USample@', 'keywords' => '@USample@'];
                $this->addMetadata($metadata);
    }
    /**
     * Display a listing of the @USample@.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->addJsCss();
        $this->loadJsCSS($data['jsFiles'], $data['cssFiles']);
        return view('@USample@::index');
    }

    /**
     * Display a listing of the Survey categories.
     *
     * @param array $request request array
     *
     * @return Response
     */
    public function getJsonList(Request $request)
    {
        $columns = @COLUMNS@;   // List of columns (field name) those are sortable and searchable

        $filter['search']    = $request->input('search')['value'];
        $filter['start']     = $request->input('start');
        $filter['length']    = $request->input('length');
        $filter['sortBy']    = $columns[$request->input('order')[0]['column']];
        $filter['sortOrder'] = $request->input('order')[0]['dir'];

        $@LSample@List = @USample@::get@USample@Listing($filter);
        $total      = @USample@::get@USample@Count($filter);
        $result     = ["draw" => uniqid(), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $@LSample@List];

        return response()->json($result);
    }
    /**
     * Show the form for creating a new @USample@.
     *
     * @return Response
     */
    public function create()
    {
        $input      = Input::all();
        $validation = Validator::make($input, @USample@::$rules);
        if ($validation->passes()) {
            return @USample@::createRecord($input);
        }
        $messages = $validation->messages();
        if (\Request::ajax()) {
            return \Response::json(array ('errors' => $messages));
        } else {
            return Redirect::route('@LSample@.index')
                            ->withInput()
                            ->withErrors($validation)
                            ->with('errormessage', 'There were validation errors.');
        }
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
        $@LSample@ = @USample@::find($id);
        return \Response::json($@LSample@);
    }

    /**
     * Show the form for editing the specified @USample@.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function edit($id)
    {
        $@LSample@ = @USample@::find($id);
        if (is_null($@LSample@)) {
            return Redirect::route('@LSample@.index');
        }
        return \Response::json($@LSample@);
    }

    /**
     * Update the specified @USample@ in database.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        $validation = Validator::make($input, @USample@::$rules);
        if ($validation->passes()) {
            return @USample@::updateRecord($id, $input);
        }
        $messages = $validation->messages();
        if (\Request::ajax()) {
            return \Response::json(array ('errors' => $messages));
        } else {
        return Redirect::route('@LSample@.edit', $id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('errorMessage', 'There were validation errors.');
        }

    }

    /**
     * Remove the specified @USample@ from database.
     *
     * @param int $id record id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //It's hard delete
        $@LSample@ = @USample@::deleteRecord($id);
        if (\Request::ajax()) {
            return \Response::json($@LSample@);
        } else {
            return Redirect::route('@LSample@.index');
        }
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
        $jsFiles = ['https://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js',
            "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js",
            "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js",
            "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js",
            "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js",
            $this->url . '/theme/'.$this->theme.'/assets/@LSample@/js/@LSample@.js'
        ];



        $cssFiles = ["https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css",
                "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css"
            ];

        return [
            'jsFiles'  => $jsFiles,
            'cssFiles' => $cssFiles,
        ];
    }
}
