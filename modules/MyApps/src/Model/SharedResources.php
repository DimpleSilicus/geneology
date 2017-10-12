<?php

/**
 * Page class to add / edit / delete Shared_resources
 *
 * @name       SharedResources.php
 * @category   Model
 * @package    MyApps
 * @author     Swapnil Patil <SwapnilJ.Patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Model;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;
use Modules\Profile\Model\UserNetwork;

class SharedResources extends BaseModel
{

    protected $primaryKey = 'id';

    protected $table = 'shared_resources';

    protected $guarded = [
        'sent_date',
        'updated_at',
        'created_at'
    ];

    /**
     * This will Shared Resource details on Network.
     *
     * @name shareJournalResourceOnNetwork
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function shareResourceOnNetwork($resourceId, $resourceType, $sharedBy, $recieverStatus)
    {
        // get network users for Group/Forum
        $arrConnectedUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
        
        if (0 < count($arrConnectedUsers)) {
            $arrUserData = array();
            
            // add message to each member
            foreach ($arrConnectedUsers as $key => $user) {
                $arrUserData[] = array(
                    'resource_id' => $resourceId,
                    'resource_type' => $resourceType,
                    'shared_by' => $sharedBy,
                    'receiver_status' => $recieverStatus,
                    'shared_to' => $user["userid"]
                );
            }
        }
        
        // insert bulk data
        if (0 < count($arrUserData)) {
            return self::insert($arrUserData);
        }
        return true;
    }

    /**
     * This will share Resource with single user
     *
     * @name shareSingleResource
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function shareSingleResource($resourceId, $resourceType, $sharedBy, $recieverStatus, $sharedTo)
    {
        $shared_resources = new self();
        $shared_resources->resource_id = $resourceId;
        $shared_resources->resource_type = $resourceType;
        $shared_resources->shared_by = $sharedBy;
        $shared_resources->receiver_status = $recieverStatus;
        $shared_resources->shared_to = $sharedTo;
        $success = $shared_resources->save();
        return $success;
    }

    /**
     * This will get shared pictures by user id
     *
     * @name getSharedPicturesByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     *
     * @return void
     */
    public static function getSharedPicturesByUserId($userId)
    {
        $arrPictures = array();
        
        $arrPictures = self::select('pictures.id', 'pictures.name', 'pictures.path', 'users.username as owner')->join('pictures', 'pictures.id', '=', 'shared_resources.resource_id')
            ->join('users', 'users.id', '=', 'shared_resources.shared_by')
            ->where('shared_resources.shared_to', '=', $userId)
            ->where('shared_resources.resource_type', '=', "picture")
            ->orderBy('pictures.created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrPictures;
    }

    /**
     * This will get shared videos by user id
     *
     * @name getSharedVideosByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     *
     * @return void
     */
    public static function getSharedVideosByUserId($userId)
    {
        $arrVideos = array();
        
        $arrVideos = self::select('videos.id', 'videos.name', 'videos.path', 'users.username as owner')->join('videos', 'videos.id', '=', 'shared_resources.resource_id')
            ->join('users', 'users.id', '=', 'shared_resources.shared_by')
            ->where('shared_resources.shared_to', '=', $userId)
            ->where('shared_resources.resource_type', '=', "video")
            ->orderBy('videos.created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrVideos;
    }

    /**
     * This will get shared journals by user id
     *
     * @name getSharedPicturesByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     *
     * @return void
     */
    public static function getSharedJournalsByUserId($userId)
    {
        $arrPictures = array();
        
        $arrPictures = self::select('journals.id', 'journals.name', 'journals.description', 'users.username as owner','users.id as uid')
            ->join('journals', 'journals.id', '=', 'shared_resources.resource_id')
            ->join('users', 'users.id', '=', 'shared_resources.shared_by')
            ->where('shared_resources.shared_to', '=', $userId)
            ->where('shared_resources.resource_type', '=', "Journal")
            ->orderBy('journals.created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrPictures;
    }

    /**
     * This will get shared events by user id
     *
     * @name getSharedEventsByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     *
     * @return void
     */
    public static function getSharedEventsByUserId($userId)
    {
        $arrPictures = array();
        
        $arrPictures = self::select('app_events.id', 'app_events.name', 'app_events.event_date', 'app_events.place', 'users.username as owner')->join('app_events', 'app_events.id', '=', 'shared_resources.resource_id')
            ->join('users', 'users.id', '=', 'shared_resources.shared_by')
            ->where('shared_resources.shared_to', '=', $userId)
            ->where('shared_resources.resource_type', '=', "Event")
            ->orderBy('app_events.created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrPictures;
    }
}
