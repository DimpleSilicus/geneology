<?php

/**
 * Page class to add / edit / delete Pages
 *
 * @name       Page.php
 * @category   Model
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */

namespace Modules\Pages\Model;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;

/**
 * Page class to add / edit / delete Pages
 *
 * @name       Page.php
 * @category   Model
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */
class PageCategory extends BaseModel
{

    protected $primaryKey = 'id';

    /**
     * This will lists all the page categories created by the admin.
     *
     * @name   getAllPageCategories
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $filter - of login user data
     *
     * @return void
     */
    static function getAllPageCategories($filter)
    {

        $query = self::select('name', 'status', 'id as edit', 'id as delete')
                ->where('status', '!=', '2');

        if ($filter['search']) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
        }

        $query->offset($filter['start']);
        $query->limit($filter['length']);
        $query->orderBy($filter['sortBy'], $filter['sortOrder']);
        $result = $query->get();
        return $result;
    }

    /**
     * This will return notification count.
     *
     * @name   getPageCategoryCount
     * @access public static
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param array $filter values for filter records
     *
     * @return void
     */
    static function getPageCategoryCount($filter)
    {
        if ($filter['search']) {
            $query  = self::where('name', 'like', '%' . $filter['search'] . '%');
            $result = $query->count();
        } else {
            $result = self::where('status', '!=', '2')->count();
        }
        return $result;
    }

    /**
     * This will lists all active page categories created by the admin.
     *
     * @name   getAllActivePageCategories
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $userId - of login user
     *
     * @return void
     */
    static function getAllActivePageCategories($userId)
    {
        return $pageCategories = self::where('created_by', '=', $userId)->where('status', '=', '1')->orderBy('name', 'asc')->get();
    }

    /**
     * This will saves page details to the database.
     *
     * @name   savePageCategoryDetails
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $request - of page which you want to edit
     * @param array : $userId  - of page which you want to edit
     *
     * @return void
     */
    static function savePageCategoryDetails($request, $userId)
    {
        $status = $request->status == 'on' ? '1' : '0';
        if (isset($request->id) && $request->id != '') {
            $userId          = Auth::id();
            $id              = $request->id;
            $page            = self::find($id);
            $page->name      = $request->name;
            $page->status    = $status;
            $page->updatedBy = $userId;
            $page->save();
        } else {
            $userId          = Auth::id();
            $page            = new self();
            $page->name      = $request->name;
            $page->status    = $status;
            $page->createdBy = $userId;
            $page->updatedBy = $userId;
            $page->save();
        }
    }

    /**
     * This will delete page category created by the login users.
     *
     * @name   deletePageCategory
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param obj $id request object to validate
     *
     * @return void
     */
    static function deletePageCategory($id)
    {
        $userId          = Auth::id();
        $page            = self::find($id);
        $page->status    = '2';
        $page->updatedBy = $userId;
        $page->deletedAt = date('Y-m-d h:i:s');
        $page->save();
    }

}
