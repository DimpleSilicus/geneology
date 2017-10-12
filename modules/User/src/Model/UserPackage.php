<?php
/**
 * UserNetwork class to add / edit / delete UserNetwork
 *
 * @name       UserNetwork.php
 * @category   UserNetwork
 * @package    Profile
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserPackage extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'packages';

      

    /**
     * Get list of packages based on selected Gedcam file
     *
     * @name getUserRequestReceived
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getPackageDetail($gedcomValue)
    {
        $arrRequests = self::select('gedcom', 'amount')
            ->where('id', '=', $gedcomValue)            
            ->get()
            ->toArray();
        
        return $arrRequests;
    }
	
    /**
     * User can send approve and reject user request
     *
     * @name approveRejectUserRequest
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function approveRejectUserRequest($requestId, $type)
    {
        $status = '1';
        
        if ("reject" == $type) {
            $status = '2';
        }
        
        $objRequest = UserNetwork::find($requestId);
        $objRequest->status = $status;
        
        $success = $objRequest->save();
        
        // add user accepted connect request notification
        if ($success && "reject" != $type) {
            
            $objUser = Auth::user();
            $uname = $objUser->username;
            $message = $uname . " accepted your connect request";
            $receiverId = $objRequest->sender_id;
            
            Notifications::addNotification($message, "con_req_accepted", '0', $receiverId);
        }
        
        return $success;
    }

		public function isOnline()
	{
		return Cache::has('user-is-online-' . $this->id);
	}
	
    /**
     * Get all users those are in the users network
     *
     * @name getNetwokUsersByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getNetwokUsersByUserId($userId)
    {
        $arrUsers = self::select('users.id as userid', 'users.username','users.is_online','user_network.relation')->join('users', 'users.id', '=', 'user_network.sender_id')
            ->where('user_network.receiver_id', '=', $userId)
            ->where('user_network.status', '=', '1')
            ->get()
            ->toArray();
        
        $arrUsers2 = self::select('users.id as userid', 'users.username','users.is_online','user_network.relation')->join('users', 'users.id', '=', 'user_network.receiver_id')
            ->where('user_network.sender_id', '=', $userId)
            ->where('user_network.status', '=', '1')
            ->get()
            ->toArray();
        
        $arrAllUsers = array_merge($arrUsers, $arrUsers2);
        
        return $arrAllUsers;
    }

	 /**
     * Function to get all packages based on User has not selected package.
     * 
     *
     * @name getAllPackagesNotByUser
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     *
     * @return array
     */
    public static function getAllPackagesNotByUser()
    {
        
        //       SELECT * FROM `packages` where packages.id not in (select transactions.package_id from transactions WHERE transactions.user_id=111)
        $arrPackages = self::select('packages.*')                
                ->whereNotIn('packages.id', function ($q) {
                    $q->select('transactions.package_id')
                    ->where('transactions.user_id', '=', Auth::id())
                    ->from('transactions');
                })                
                ->get()
                ->toArray();
        
        
        
        return $arrPackages;
    }

	/**
     * Function to get all packages based on User has not selected package.
     * 
     *
     * @name getAllPackages
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     *
     * @return array
     */
    public static function getAllPackagesByUser($id)
    {
        //SELECT * FROM transactions INNER JOIN packages ON transactions.package_id = packages.id WHERE transactions.user_id = 7;   //new
        //       SELECT * FROM `packages` where packages.id in (select transactions.package_id from transactions WHERE transactions.user_id=111)        
        $arrUserPackages= self::select('*')                
                ->from('transactions')                
                ->join('packages', 'transactions.package_id', '=', 'packages.id')
                ->where('transactions.user_id', '=', $id)
                ->get()
                ->toArray();
        
        
        
        return $arrUserPackages;
    }
    
    public static function getAllPackages()
    {
        $arrRequests = self::select('*')                  
            ->get()
            ->toArray();
        
        return $arrRequests;
    }
}
