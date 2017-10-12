<?php
/**
 * UserGedcomFiles class to add / edit / delete Member Relations
 *
 * @name       UserGedcomFiles.php
 * @category   UserGedcomFiles
 * @package    Gedcom
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\Gedcom\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserGedcomFiles extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'user_gedcom_files';

    public $timestamps = false;

    /**
     * Function to add Member Relation
     *
     * @name addMemberRelation
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function uploadGedcomFile($file, $fileName)
    {
        
        // get users details
        $objUser = Auth::user();
        
        // set file path to upload and new name
        $originalFileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $newFileName = time() . uniqid() . "." . $fileExtension;
        $appUrl = Config::get('app.url');
        
        $destinationPath = 'storage/app/public/users_uploaded_files/gedcom/' . $objUser->username . '_' . $objUser->id;
        
        // move Uploaded File
        $file->move($destinationPath, $newFileName);
        
        // uploaded file path
        $filePath = $destinationPath . '/' . $newFileName;
        
        // add data to database
        $objGedcomFile = new UserGedcomFiles();
        
        $objGedcomFile->file_name = $fileName;
        $objGedcomFile->file_path = $filePath;
        $objGedcomFile->user_id = $objUser->id;
        
        $objGedcomFile->save();
        
        return array(
            "filePath" => $filePath,
            "fileId" => $objGedcomFile->id
        );
    }

    /**
     * Function to add message to get all users messages
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getUserGedComFiles($userId)
    {
        $arrGedcomFiles = self::select('id', 'file_name','user_id')->where('user_id', '=', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrGedcomFiles;
    }
}
