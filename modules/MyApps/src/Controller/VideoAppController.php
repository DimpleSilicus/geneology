<?php

/**
 *  Controller for manage videos
 *
 * @name       VideoAppController
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
use Modules\MyApps\Model\Videos;
use Modules\MyApps\Model\SharedResources;
use Modules\Profile\Model\UserNetwork;

/**
 * VideoAppController class for view method.
 *
 * @category VideoAppController
 * @package MyApps
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://google.com
 * @name VideoAppController
 * @version Release:<v.1>
 * @link http://google.com
 */
class VideoAppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $jsFiles[] = $this->url . 'theme/' . Config::get('app.theme') . '/assets/myapps/js/video-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
    }

    /**
     * This function used to get all videos uploaded by user
     *
     * @name getAllVideos
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getAllVideos()
    {
        $arrVideos = Videos::getVideosByUsedId(Auth::id());
        $arrNetworkUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
        
        $appUrl = Config::get('app.url');
        
        return view('MyApps::video-app.list-videos')->with('arrVideos', $arrVideos)
            ->with('arrNetworkUsers', $arrNetworkUsers)
            ->with('appUrl', $appUrl);
    }

    /**
     * This function used to upload video
     *
     * @name uploadVideo
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function uploadVideo(Request $request)
    {
        // validate inputs
        $messages = [
            'uVideo.required' => 'Video is required.',
            'uVideo.mimes' => 'Please add valid picture file.',
            'fileName.required' => 'Video Name is required.'
        ];
        
        $this->validate($request, [
            'uVideo' => 'required|mimes:mp4',
            'fileName' => 'required'
        
        ], $messages);
        
        $file = $request->file('uVideo');
        $fileName = $request->fileName;
        
        // upload picture
        $upload = Videos::uploadVideo($file, $fileName);
        
        //
        if ($upload) {
            \Session::flash('success', 'Video uploaded successfully.');
        }
    }

    /**
     * This function used to edit video details
     *
     * @name getVideoDetailsByVideoId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getVideoDetailsByVideoId(Request $request)
    {
        // validate inputs
        $messages = [
            'videoId.required' => 'Video ID is required.'
        ];
        
        $this->validate($request, [
            'videoId' => 'required'
        
        ], $messages);
        
        $picDetails = Videos::getVideoDetailsByVideoId($request->videoId);
        
        return response()->json($picDetails);
    }

    /**
     * This function used to edit video details
     *
     * @name editVideo
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function editVideo(Request $request)
    {
        // validate inputs
        $messages = [
            'videoId.required' => 'Video Id is required.',
            'videoId.numeric' => 'Video Id should be numeric.',
            'fileName.required' => 'Video Name is required.'
        ];
        
        $this->validate($request, [
            'videoId' => 'required|numeric',
            'fileName' => 'required'
        
        ], $messages);
        
        // update picture details
        $update = Videos::editVideoDetails($request->videoId, $request->fileName);
        
        if ($update) {
            \Session::flash('success', 'Video updated successfully.');
        }
    }

    /**
     * This function used to delete video
     *
     * @name deleteVideo
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function deleteVideo(Request $request)
    {
        // validate inputs
        $messages = [
            'videoId.required' => 'Picture Id is required.',
            'videoId.numeric' => 'Picture Id should be numeric.'
        ];
        
        $this->validate($request, [
            'videoId' => 'required|numeric'
        
        ], $messages);
        
        // update picture details
        $delete = Videos::deleteVideoByVideoId($request->videoId);
        
        if ($delete) {
            \Session::flash('success', 'Video deleted successfully.');
        }
    }

    /**
     * This function used to share video
     *
     * @name shareVideo
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function shareVideo(Request $request)
    {
        // validate inputs
        $messages = [
            'videoId.required' => 'Video Id is required.',
            'videoId.numeric' => 'Video Id should be numeric.'
        ];
        
        $this->validate($request, [
            'videoId' => 'required|numeric'
        
        ], $messages);
        
        $resourceId = $request->videoId;
        $resourceType = 'video';
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        
        $shareVideo = SharedResources::shareResourceOnNetwork($resourceId, $resourceType, $sharedBy, $recieverStatus);
        
        if ($shareVideo) {
            \Session::flash('success', 'Video shared within network successfully .');
        }
    }
}
