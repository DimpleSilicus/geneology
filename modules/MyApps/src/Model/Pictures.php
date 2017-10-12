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
use Illuminate\Support\Facades\Config;
use Modules\MyApps\Model\SharedResources;

class Pictures extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'pictures';

    public $timestamps = false;

    /**
     * Function to add message to all group members
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function uploadPicture($file, $fileName)
    {
        // get users details
        $objUser = Auth::user();
        
        // set file path to upload and new name
        $originalFileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $newFileName = time() . uniqid() . "." . $fileExtension;
        $appUrl = Config::get('app.url');
        
        $destinationPath = 'storage/app/public/users_uploaded_files/pictures/' . $objUser->username . '_' . $objUser->id;
        
        // move Uploaded File
        $file->move($destinationPath, $newFileName);
        
        // uploaded file path
        $filePath = $destinationPath . '/' . $newFileName;
        
        // add data to database
        $objPictures = new self();
        
        $objPictures->name = $fileName;
        $objPictures->path = $filePath;
        $objPictures->user_id = $objUser->id;
        $objPictures->status = '0';
        
        $success = $objPictures->save();
        
        return $success;
    }

    /**
     * Function to get pictures By Used Id
     *
     * @name getPicturesByUsedId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getPicturesByUsedId($userId)
    {
        $arrPictures = array();
        
        $arrPictures = self::select('id', 'name', 'path', 'user_id as owner')->where('user_id', '=', $userId)
            ->where('status', '<>', '2')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        
        $arrSharedPictures = SharedResources::getSharedPicturesByUserId($userId);
        
        $arrAllPictures = array_merge($arrPictures, $arrSharedPictures);
        
        return $arrAllPictures;
    }

    /**
     * Function to get pictures details By Id
     *
     * @name getPictureDetailsByPictureId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getPictureDetailsByPictureId($picId)
    {
        $arrPicDetails = array();
        
        if ('' != $picId) {
            $arrPicDetails = self::select('id', 'name', 'path')->where('id', '=', $picId)
                ->get()
                ->toArray();
        }
        
        return $arrPicDetails;
    }

    /**
     * Function to edit file name
     *
     * @name addNetworkGroup
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function editPictureDetails($picId, $fileName)
    {
        $objPick = Pictures::find($picId);
        
        $objPick->name = $fileName;
        
        $success = $objPick->save();
        
        return $success;
    }

    /**
     * Function used to delete picture
     *
     * @name deletePictureByPictureId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function deletePictureByPictureId($picId)
    {
        $objPick = Pictures::find($picId);
        
        $objPick->status = '2';
        
        $success = $objPick->save();
        
        return $success;
    }
}
