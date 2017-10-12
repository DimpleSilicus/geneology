<?php

/**
 *  Controller to add / edit / delete Events
 *
 * @name       ResourceAppController
 * @category   Controller
 * @package    Resource
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Modules\MyApps\Model\Queue;
use Modules\Gedcom\Model\Families;
use Modules\Gedcom\Model\Members;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;


class ResourceAppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/myapps/js/resource-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
		
        parent::__construct();
    }    
	
    
    /**
     * This will show Resource/Queue list
     *
     * @name   getResourceList 
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
	public function getResourceList()
	{
	    $arrQueue = array();
	    $arrQueue = Queue::getAllQueue();
	    $html = view::make('MyApps::resource-app.list-resource',compact('arrQueue'))->render();
	    return $html;
	}
	
	
	/**
	 * This will show Search Resource List
	 *
	 * @name   searchResourceList
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @return void
	 */
	public function searchResourceList(Request $request)
	{
	    // validate inputs
	    $messages = [
	        'ResourceName.required'  => 'Name is required.'
	    ];
	    
	    $this->validate($request, [
	        'ResourceName'  => 'required'
	    ], $messages);
	    
	    $name = $request->ResourceName;
	    $place = $request->ResourcePlace;
	    $year  = $request->ResourceYear;
	    $genarationGap = $request->GenerationGap;
	    	    
	    $arrResource = array();
	    
	    if(isset($name) && !empty($name))
	    {
	        $description = $name;
	        
	        if(!empty($place))
	        {
	            $description.=' + '.$place;
	        }
	        
	        if(!empty($year))
	        {
	            $description.= ' + '.$year;
	        }
	        
	        if(!empty($genarationGap))
	        {
	            $description.= ' + '.$genarationGap;
	        }
	        
	        
	        $file        = '';
	        $userid      = Auth::id();
	        $status      = '0';
	        
	        $saveSearchQueue = Queue::saveSearchQueue($description,$userid,$status);
	        $arrResource = Members::SearchMemberDetails($name,$place,$year,$genarationGap);
	    }
	    
	    if(count($arrResource)=='0')
	    {
	        $arrResource = false;
	    }
	    
	    return response()->json($arrResource);
	    return View('MyApps::resource-app.list-resource');
	}
	
	
	/**
	 * This will save new Queue into database
	 *
	 * @name   AddQueue
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @return void
	 */
	public function AddQueueDetails(Request $request)
	{
	    
	    // validate inputs
	    $messages = [
	        'Description.required'  => 'Description is required.',
	        'FileUpload.required' => 'File is required.'
	    ];
	    
	    $this->validate($request, [
	        'Description'  => 'required',
	        'FileUpload' => 'required'
	    ], $messages);
	    	    
	    $description = $request->Description;
	    $file        = $request->FileUpload;
	    $userid      = Auth::id();
	    $status      = '0';
	    
	    $addQueue  = Queue::saveQueueDetails($description,$userid,$status,$file);
	    
	    if($addQueue)
	    {
	        \Session::flash('success','Queue added successfully .');
	    }
	    
	}
	
	/**
	 * This will delete queue record created by the user. 
	 *
	 * @name   deleteQueueRecord
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @paarmeter $id used to delete record
	 * @return void
	 */
	
	public function deleteQueueRecord(Request $request)
	{
	    $id          = $request->id;
	    $deleteQueue = Queue::deleteQueue($id);
	    if ($deleteQueue)
	    {
	        \Session::flash('success','Queue deleted successfully .');
	    }
	}
	
	/**
	 * This will delete queue record created by the user.
	 *
	 * @name   deleteQueueRecord
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @paarmeter $id used to delete record
	 * @return void
	 */
	
	public function memberDetails(Request $request)
	{
	    $id        = $request->id;
	    $arrFamily = array();
	    $arrFamily = Members::getMemberInfo($id); 
	    return response()->json($arrFamily);
	    return view('MyApps::resource-app')->with('arrFamily',$arrFamily);	    
	}
	
	
	
}
