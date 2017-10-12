<?php
/**
 * Pictures class to add / edit / delete Pictures
 *
 * @name       Pictures.php
 * @category   Pictures
 * @package    MyApps
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\MyApps\Model\SharedResources;

class Videos extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'videos';

    public $timestamps = false;

    /**
     * Function to upload Video
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function uploadVideo($file, $fileName)
    {
        // get users details
        $objUser = Auth::user();
        
        // set file path to upload and new name
        $originalFileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $newFileName = time() . uniqid() . "." . $fileExtension;
        
        $destinationPath = 'storage/app/public/users_uploaded_files/videos/' . $objUser->username . '_' . $objUser->id;
        
        // move Uploaded File
        $file->move($destinationPath, $newFileName);
        
        // uploaded file path
        $filePath = $destinationPath . '/' . $newFileName;
        
        // add data to database
        $objVideo = new self();
        
        $objVideo->name = $fileName;
        $objVideo->path = $filePath;
        $objVideo->user_id = $objUser->id;
        $objVideo->status = '0';
        
        $success = $objVideo->save();
        
        return $success;
    }

    /**
     * Function to get videos By Used Id
     *
     * @name getVideosByUsedId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getVideosByUsedId($userId)
    {
        $arrVideos = self::select('id', 'name', 'path', 'user_id as owner')->where('user_id', '=', $userId)
            ->where('status', '<>', '2')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        
        $arrSharedVideos = SharedResources::getSharedVideosByUserId($userId);
        
        $arrAllVideos = array_merge($arrVideos, $arrSharedVideos);
        
        return $arrAllVideos;
    }

    /**
     * Function to get video details By Id
     *
     * @name getVideoDetailsByVideoId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getVideoDetailsByVideoId($videoId)
    {
        $arrVideoDetails = array();
        
        if ('' != $videoId) {
            $arrVideoDetails = self::select('id', 'name', 'path')->where('id', '=', $videoId)
                ->get()
                ->toArray();
        }
        
        return $arrVideoDetails;
    }

    /**
     * Function to edit file name
     *
     * @name editVideoDetails
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function editVideoDetails($videoId, $fileName)
    {
        $objVideo = Videos::find($videoId);
        
        $objVideo->name = $fileName;
        
        $success = $objVideo->save();
        
        return $success;
    }

    /**
     * Function used to delete video
     *
     * @name deleteVideoByVideoId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function deleteVideoByVideoId($videoId)
    {
        $objVideo = Videos::find($videoId);
        
        $objVideo->status = '2';
        
        $success = $objVideo->save();
        
        return $success;
    }
}
