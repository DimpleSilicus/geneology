<?php

/**
 *  User model
 *
 * @name       User
 * @category   Model
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\MessageSystem\Model;

use App\BaseModel;

/**
 * Personal message model
 *
 * @category ModelClass
 * @package  MessageSystem
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @name     User
 * @version  Release:<v.1>
 * @link     http://www.silicus.com/
 */
class User extends BaseModel
{

    protected $table = 'users';

    /**
     * Fetching all users list except current user
     *
     * @name   getUserList
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    static function getUserList()
    {
        return User::all();
    }

    /**
     * Getting recipentid
     *
     * @name   getRecipentId
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param String $recipName Recipent name
     *
     * @return void
     */
    static function getRecipentId($recipName)
    {
        return User::where('name', '=', $recipName)->get();
    }

}
