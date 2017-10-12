<?php

/**
 *  Controller to add / edit / delete Events
 *
 * @name       ResourceController
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
use Modules\MyApps\Model\SharedResources;
use Modules\Profile\Model\UserNetwork;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;


class ResourceController extends Controller
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
	
	public function getResourceList()
	{
		return View('MyApps::resource-app.list-resource');
	}
}
