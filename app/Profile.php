<?php

/**
 * Model class for Profile table
 *
 * @name       Profile.php
 * @category   Model
 * @package    ACL
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 53dde8b92a0dba2d5765c581784a7cf82ca4075a $
 * @link       None
 * @filesource
 */

namespace App;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;

/**
 * Model class for Profile table
 *
 * @name     Profile
 * @category Model
 * @package  ACL
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Profile extends BaseModel
{

    /**
     * Set default timestamp as false
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Set fillable fields
     *
     * @var array
     */
    protected $fillable = ['gender', 'date_of_birth', 'position', 'company', 'phone', 'mobile_phone', 'address', 'facebook', 'twitter', 'google', 'about_me', 'biography', 'news_letter'];

    /**
     * Save user profile
     *
     * @name   saveProfile
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $key    Table key
     * @param string $value  Table field value
     * @param int    $userId User Id
     *
     * @return void
     */
    public static function saveProfile($key, $value, $userId)
    {
        $result         = self::firstOrNew(["user_id" => $userId]);
        $result->userId = $userId;
        $result->$key   = $value;
        return $result->save();
    }

}
