<?php

/**
 *  Controller to add / edit / delete Journals
 *
 * @name       MyAppsController
 * @category   Plugin
 * @package    Journal
 * @author     Amol Savat <amol.savat@silicus.com>
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
use Modules\MyApps\Model\SharedResources;

class MyAppsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/myapps/js/journal-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
		
        parent::__construct();
    }

    public function getMyNetwork()
    {
        return view('MyApps::my-apps');
    }

    /**
     * This will Share Resource To single User.
     *
     * @name ShareResourceToUser
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     * @return void
     */
    public function ShareResourceToUser(Request $request)
    {
        $resourceId = $request->resourceId;
        $resourceType = $request->resourceType;
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        $sharedTo = $request->shareTo;
        $shareJournals1 = SharedResources::shareSingleResource($resourceId, $resourceType, $sharedBy, $recieverStatus, $sharedTo);
        if ($shareJournals1) {
            \Session::flash('success', $request->resourceType . ' shared successfully .');
        }
    }
}
