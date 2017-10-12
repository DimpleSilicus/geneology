<?php

/**
 *  Controller to search / add / edit / delete tutoral
 *
 * @name       TutorialAppController
 * @category   Controller
 * @package    Tutorial
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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Modules\MyApps\Model\Tutorial;


class TutorialAppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/myapps/js/tutorial-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
		
        parent::__construct();
    }    
    
    
    /**
     * This will show Tutorial page
     *
     * @name   showTutorial
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
	public function showTutorial(Request $request)
	{     
	    return view('MyApps::tutorial-app.list-tutorial');
	}
	
	
	
	/**
	 * This will show
	 *
	 * @name
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @return void
	 */
	public function TutorialList(Request $request)
	{
	    
	    $arrTutorial = array();
	    $arrTutorial = Tutorial::getTutorialList();    
	    return response()->json($arrTutorial);
	    return view('MyApps::tutorial-app.list-tutorial');
	}
	
	
	/**
	 * This will show Search TutorialList
	 *
	 * @name   getSearchTutorialList
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @return void
	 */
	public function getSearchTutorialList(Request $request)
	{
	   
	    // validate inputs
	    $messages = [
	        'search.required' => 'Search is required.'
	    ];
	    
	    $this->validate($request, [
	        'search' => 'required'
	    ], $messages);
	    
	    $search = $request->search; 
	    $arrTutorial = array();
	    
	    if(isset($search) && !empty($search))
	    {     
	      $arrTutorial = Tutorial::SearchTutorialList($search);	        
	    }
	    
	    if(count($arrTutorial)=='0')
	    {
	        $arrTutorial = false;
	    }
	   
	    return response()->json($arrTutorial);
	    return view('MyApps::tutorial-app.list-tutorial');
	}
		
	
}
