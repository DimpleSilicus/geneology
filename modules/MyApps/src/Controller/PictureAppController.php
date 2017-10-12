<?php

/**
 *  Controller for viewing all users logs
 *
 * @name       PictureAppController
 * @category   Plugin
 * @package    MyApps
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Modules\MyApps\Model\Pictures;
use Modules\MyApps\Model\SharedResources;
use Modules\Profile\Model\UserNetwork;

/**
 * PictureAppController class for view method.
 *
 * @category PictureAppController
 * @package MyApps
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://google.com
 * @name PictureAppController
 * @version Release:<v.1>
 * @link http://google.com
 */
class PictureAppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $jsFiles[] = $this->url . 'theme/' . Config::get('app.theme') . '/assets/myapps/js/picture-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
    }

    /**
     * This function used to get all picture uploaded by user
     *
     * @name getAllPictures
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getAllPictures()
    {
        $arrPictures = Pictures::getPicturesByUsedId(Auth::id());
        $arrNetworkUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
        
        $appUrl = Config::get('app.url');
        return view('MyApps::picture-app.list-pictures')->with('arrPictures', $arrPictures)
            ->with('arrNetworkUsers', $arrNetworkUsers)
            ->with('appUrl', $appUrl);
    }

    /**
     * This function used to upload picture
     *
     * @name uploadPicture
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function uploadPicture(Request $request)
    {
        // validate inputs
        $messages = [
            'uPicture.required' => 'Picture is required.',
            'uPicture.mimes' => 'Please add valid picture file.',
            'fileName.required' => 'Picture Name is required.'
        ];
        
        $this->validate($request, [
            'uPicture' => 'required|mimes:jpeg,jpg,png',
            'fileName' => 'required'
        
        ], $messages);
        
        $file = $request->file('uPicture');
        $fileName = $request->fileName;
        
        // upload picture
        $upload = Pictures::uploadPicture($file, $fileName);
        
        //
        if ($upload) {
            \Session::flash('success', 'Picture uploaded successfully.');
        }
    }

    /**
     * This function used to edit picture details
     *
     * @name editPicture
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getPictureDetailsByPictureId(Request $request)
    {
        // validate inputs
        $messages = [
            'picId.required' => 'Group ID is required.'
        ];
        
        $this->validate($request, [
            'picId' => 'required'
        
        ], $messages);
        
        $picDetails = Pictures::getPictureDetailsByPictureId($request->picId);
        
        return response()->json($picDetails);
    }

    /**
     * This function used to edit picture details
     *
     * @name editPicture
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function editPicture(Request $request)
    {
        // validate inputs
        $messages = [
            'picId.required' => 'Picture Id is required.',
            'picId.numeric' => 'Picture Id should be numeric.',
            'fileName.required' => 'Picture Name is required.'
        ];
        
        $this->validate($request, [
            'picId' => 'required|numeric',
            'fileName' => 'required'
        
        ], $messages);
        
        // update picture details
        $update = Pictures::editPictureDetails($request->picId, $request->fileName);
        
        if ($update) {
            \Session::flash('success', 'Picture updated successfully.');
        }
    }

    /**
     * This function used to delete picture
     *
     * @name deletePic
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function deletePic(Request $request)
    {
        // validate inputs
        $messages = [
            'picId.required' => 'Picture Id is required.',
            'picId.numeric' => 'Picture Id should be numeric.'
        ];
        
        $this->validate($request, [
            'picId' => 'required|numeric'
        
        ], $messages);
        
        // update picture details
        $delete = Pictures::deletePictureByPictureId($request->picId);
        
        if ($delete) {
            \Session::flash('success', 'Picture deleted successfully.');
        }
    }

    /**
     * This function used to share picture
     *
     * @name sharePicture
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function sharePicture(Request $request)
    {
        // validate inputs
        $messages = [
            'picId.required' => 'Picture Id is required.',
            'picId.numeric' => 'Picture Id should be numeric.'
        ];
        
        $this->validate($request, [
            'picId' => 'required|numeric'
        
        ], $messages);
        
        $resourceId = $request->picId;
        $resourceType = 'picture';
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        
        $shareVideo = SharedResources::shareResourceOnNetwork($resourceId, $resourceType, $sharedBy, $recieverStatus);
        
        if ($shareVideo) {
            \Session::flash('success', 'Picture shared within network successfully .');
        }
    }
}
