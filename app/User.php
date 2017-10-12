<?php

/**
 * Model class for users table
 *
 * @name       User.php
 * @category   Model
 * @package    App
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: a0afa508e3541a07e8c1c5adc1ff5c6440e72b53 $
 * @link       None
 * @filesource
 */
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Modules\ToolKit\Workshop;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

/**
 * Model class for users table
 *
 * @name User
 * @category Model
 * @package App
 * @author Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license Silicus http://www.silicus.com
 * @version Release:<v.1>
 * @link None
 */
class User extends Authenticatable
{
    
    use Notifiable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'type',
        'status'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

	
    /**
     * Get all users
     *
     * @name getAllUsers
     * @access public
     * @author Saurabh Kolhatkar <saurabh.kolhatkar@silicus.com>
     *
     * @return void
     */
    public static function getAllUsers()
    {
        $ids = User::all();
        return $ids;
    }
        
    
    /**
     * Get filtered users
     *
     * @name getAllUsersForListing
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param arrya $filter
     *            values for filter records
     *
     * @return void
     */
    public static function getAllUsersForListing($filter)
    {
        $query = User::select('name', 'email','type', 'created_at as createdAt', 'status','is_admin', 'id as view', 'id as edit', 'id as delete');
        
        if ($filter['search']) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('email', 'like', '%' . $filter['search'] . '%');
        }
        
        // $query->whereNull('deleted_at');
        $query->offset($filter['start']);
        $query->limit($filter['length']);
        $query->orderBy($filter['sortBy'], $filter['sortOrder']);
        
        $result = $query->get();
        
        return $result;
    }

    /**
     * Get count of user list
     *
     * @name getUserCount
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param arrya $filter
     *            values for filter records
     *
     * @return void
     */
    public static function getUserCount($filter)
    {
        if ($filter['search']) {
            
            $query = User::where('name', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('email', 'like', '%' . $filter['search'] . '%');
            $query->whereNull('deleted_at');
            
            $result = $query->count();
        } else {
            $result = User::count();
        }
        return $result;
    }

    /**
     * Delete User
     *
     * @name getUserCount
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param int $id
     *            user Id
     *
     * @return void
     */
    public static function deleteUser($id)
    {
        $result = '';
        if ($id) {
            $result = User::find($id);
            $result->delete();
        }
        return $result;
    }

    /**
     * Save new password
     *
     * @name savePassword
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param Object $request
     *            New password
     *
     * @return void
     */
    public static function savePassword($request)
    {
        if (trim($request->password) != '') {
            $userId = Auth::user()->id;
            $result = self::find($userId);
            $result->password = \Hash::make($request->password);
            return $result->save();
        } else {
            return false;
        }
    }

    /**
     * Save user profile
     *
     * @name saveProfile
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $key
     *            Table key
     * @param string $value
     *            Table field value
     * @param int $userId
     *            User Id
     *
     * @return void
     */
    public static function saveProfile($key, $value, $userId)
    {
        $result = self::find($userId);
        $result->$key = $value;
        return $result->save();
    }

    /**
     * Get user information
     *
     * @name getInfo
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param int $userId
     *            User ID
     *
     * @return void
     */
    public static function getInfo($userId)
    {
        $query = [];
        
        if (Auth::user()) {
            $query = self::join('profiles', 'users.id', '=', 'profiles.user_id')->where('users.id', '=', $userId)
                ->limit(1)
                ->first();
            
            if ($query == null) {
                $query = self::where('id', '=', $userId)->limit(1)->first();
            }
            
            $query = $query->toArray();
        }
        
        return $query;
    }

    /**
     * Check login user is admin or not
     *
     * @name isAdmin
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if (count(Auth::user()->is_admin)) {
            return (strtolower(Auth::user()->is_admin) === '1') ? true : false;
        } else {
            return false;
        }
    }

    /**
     * Get users email using id
     *
     * @name getUserEmailById
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Arrty $allUserIds
     *            UserIds
     *
     * @return void
     */
    public static function getUserEmailById($allUserIds)
    {
        return self::select('email')->whereIn('id', $allUserIds)->get();
    }
	
	
	/**
     * This will lists all the user Search data
     *
     * @name   SearchUserList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function SearchUserList($search)
    {
        $result = array();
        $query = self::where('username','like','%'.$search.'%')->orWhere('email','like','%'.$search.'%');
        $result = $query->get();
        return $result;
    } 
    
    /**
     * This will update User status to the database. It will Activate/Deactivate user. Active status is 1. Deactive status is 0.  
     *
     * @name   UpdateStatus
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param array : $id - of user which you want to update
     *
     * @return void
     */
    
    public static function UpdateStatus($id,$status)
    {
        if (isset($id) && $id != '')
        {
            $user            = self::find($id);
            $user->status    = $status;
            $user->save();
            return back();
        }
    } 
   

	 /**
     * Get all users and not admin
     *
     * @name getUserLists
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public static function getUserLists()
    {
        $users = User::all()->where('is_admin','0');
        return $users;
    }
    
    /*
     * // This is required for MsSQL
     * public function getDateFormat()
     * {
     * return 'Y-m-d H:i:s.u';
     * }
     *
     * // This is required for MsSQL
     * public function fromDateTime($value)
     * {
     * return substr(parent::fromDateTime($value), 0, -3);
     * }
     */
    
    /**
     * This will update user type (Free/Paid).
     *
     * @name   UpdateUserType
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     * @return void
     */
    public static function UpdateUserType($user_id)
    {     
        $user = self::find($user_id);        
        $user->type    = '1';
        $user->save();       
               
    }
    
    /**
     * This will get user by id.
     *
     * @name   getUserById
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     * @return void
     */
    static function getUserById($UserIds)
    {
        return self::select('name', 'email', 'username', 'status', 'type')->where('id', $UserIds)->get();
    }
    
    /**
     * This will update user status by id.
     *
     * @name   getUserById
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     * @return void
     */
     static function UpdateUserStatus($id,$status)
    {
        if (isset($id) && $id != '')
        {
            $user            = self::find($id);
            $user->status    = $status;
            $user->save();
//            return back();
        }
    }     
    
    
    /**
     * Get user personal information
     *
     * @name getProfiler
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public static function getProfiler($id)
    {   
        if('' != $id)
        {
            $result = self::select('name','email','username')->where('id','=',$id)->first();
            return $result;
        }
    }
    
    /**
     * Get online users from network using Carbon Class for Cache 
     *
     * @name isOnline
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public  function isOnline()
    {
        return Cache::has('user-online-'. $this->id);
    }
    
    
    
}
