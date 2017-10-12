<?php

/**
 *  Controller for viewing all users logs
 *
 * @name       ActivityLogController
 * @category   Plugin
 * @package    Activity-Log
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ActivityLog\Controller;

//use App\Http\Controllers\Controller;
use Modules\Admin\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Modules\ActivityLog\Model\ActivityLog;
use Illuminate\Support\Facades\Input;

/**
 * ActivitylogController class for view method.
 *
 * @category ActivitylogController
 * @package  Activity-Log
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://google.com
 * @name     ActivitylogController
 * @version  Release:<v.1>
 * @link     http://google.com
 */
class ActivityLogController extends AdminBaseController
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
     * Method for viewing log data from db
     *
     * @name   view
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function view()
    {
        $jsFiles[]  = "https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js";
        $jsFiles[]  = "https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js";
        $jsFiles[]  = "https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js";
        $jsFiles[]  = "https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js";
        $jsFiles[]  = "https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js";
        $jsFiles[]  = "https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js";
        $jsFiles[]  = $this->url . '/theme/' . $this->adminTheme . '/assets/ActivityLog/js/custom.js';
        $cssFiles[] = "https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css";
        $cssFiles[] = "https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css";

        $this->loadJsCSS($jsFiles, $cssFiles);

        $data     = Input::all();
        $duration = isset($data['logduration']) ? $data['logduration'] : 0;
        return view('AL::Log')->with('duration', $duration);
    }

    /**
     * Function for get records using ajax
     *
     * @name   activityLogJsonList
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $duration time duration
     * @param Request $request  request
     *
     * @return void
     */
    public function activityLogJsonList($duration, Request $request)
    {


        $columns = ['user_id', 'email_id', 'controller', 'module', 'description', 'action', 'ip_address', 'created_at'];   // List of columns (field name) those are sortable and searchable

        $filter['search']    = $request->input('search')['value'];
        $filter['start']     = $request->input('start');
        $filter['length']    = $request->input('length');
        $filter['sortBy']    = $columns[$request->input('order')[0]['column']];
        $filter['sortOrder'] = $request->input('order')[0]['dir'];
        $filter['duration']  = $duration;

        $list   = ActivityLog::getAllActivityLog($filter);
        $total  = ActivityLog::getActivitiesCount($filter);
        $result = ["draw" => uniqid(), "recordsTotal" => $total, "recordsFiltered" => $total, "data" => $list];

        return response()->json($result);
    }

}
