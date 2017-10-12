<?php

/**
 * Page class to add / edit / delete Queue
 *
 * @name       Queue.php
 * @category   Model
 * @package    Queue
 * @author     Swapnil Patil <SwapnilJ.Patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @link       None
 * @filesource
 */

namespace Modules\MyApps\Model;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Config;

class Queue extends BaseModel
{

    protected $primaryKey = 'id';
    protected $table = 'queues';
    protected $guarded = ['created_at','updated_at','deleted_at'];

    /**
     * This will lists all the Queue created by the user.
     *
     * @name   getAllQueue
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * 
     * @return void
     */
    
    public static function getAllQueue()
    {
        $result = array();
		$userId = Auth::user()->id; 
		$result = self::select('id','name','user_id','status','path')->get()->where('user_id',$userId);
        return $result;
    } 

     /**
     * This will saves Queue details to the database.
     *
     * @name   saveQueueDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function saveQueueDetails($description,$userid,$status,$file)
    {     
        
            // get users details
            $objUser = Auth::user();
            
            // set file path to upload and new name
            $originalFileName = $file->getClientOriginalName();
            //$fileExtension = $file->getClientOriginalExtension();
            //$newFileName = time() . uniqid() . "." . $fileExtension;
            $appUrl = Config::get('app.url');
            
            $destinationPath = 'storage/app/public/users_uploaded_files/resource/' . $objUser->username . '_' . $objUser->id;
            
            // move Uploaded File
            $file->move($destinationPath, $originalFileName);
            
            // uploaded file path
            $filePath = $destinationPath . '/' . $originalFileName; 
            
            $queue               = new self();
            $queue->name         = $description;
            $queue->user_id      = $userid;
            $queue->status       = $status;
            $queue->path         = $filePath;
            $success = $queue->save(); 
            return $success;			
    }
    
    
    /**
     * This will saves Search Queue to the database.
     *
     * @name   saveSearchQueue
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function saveSearchQueue($description,$userid,$status)
    {  
        $queue               = new self();
        $queue->name         = $description;
        $queue->user_id      = $userid;
        $queue->status       = $status;
        $success = $queue->save();
        return $success;
    }
 
    /**
     * This will delete queue created by the users.
     *
     * @name   deleteQueue
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param obj $id request object to delete queue
     *
     * @return void
     */
    
    public static function deleteQueue($id)
    {
        $queueId = Queue::find($id);
        $queueId ->delete();
        return back();
    }
	
	/**
     * This will lists all the Queue Search data
     *
     * @name   SearchQueueDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function SearchQueueDetails($name,$place,$year,$genarationGap)
    {
        $result = array();
        $result = self::where('name','like','%'.$name.'%') ->orWhere('name','like','%'.$place.'%')->orWhere('name','like','%'.$genarationGap.'%')->get();
        return $result;
    }
      
   

}
