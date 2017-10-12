<?php

/**
 *  Controller to add / edit / delete / search Maps
 *
 * @name       MapsController
 * @category   Controller
 * @package    Maps
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Maps\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Modules\Gedcom\Model\Members;
use Modules\Gedcom\Model\UserGedcomFiles;




class MapsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/maps/js/maps.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
		
        parent::__construct();
    }    
	
    
    /**
     * This will show World Map Page
     *
     * @name   showWorldMap 
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function showWorldMap(Request $request)
	{
	    $memberCountry = array();
	    $metadata = ['title' => 'Maps', 'description' => 'Maps', 'keywords' => 'Maps'];
	    $this->addMetadata($metadata);
	    $map = new Members();
	    return view('Maps::mapWorld',['map'=>$map]);
	}
	
	
	/**
	 * This will show Personal Map Page
	 *
	 * @name   showPersonalMap
	 * @access public
	 * @author Swapnil Patil <swapnilj.patil@silicus.com>
	 * @return void
	 */
	public function showPersonalMap()
	{
	    $metadata = ['title' => 'Maps', 'description' => 'Maps', 'keywords' => 'Maps'];
	    $authID =  Auth::id();
	    $this->addMetadata($metadata);
	    $map = new Members();
	    $gedcom = new UserGedcomFiles();
	    $memberCountry = $gedcom->getUserGedComFiles($authID);
	    return view('Maps::mapPersonnel',['map'=>$map,'memberCountry'=>$memberCountry]);
	}
	
	
	
	
}




