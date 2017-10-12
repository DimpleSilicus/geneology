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
class Page extends BaseModel
{

    protected $primaryKey = 'id';

    /**
     * This will lists all the pages created by the admin.
     *
     * @name   getAllPages
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $filter - filter details
     *
     * @return void
     */
    static function getAllPages($filter)
    {
        $query = self::select('name', 'meta_title', 'slug', 'publish', 'id as preview', 'id as edit', 'id as delete')
                ->where('publish', '!=', '2');

        if ($filter['search']) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('meta_title', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('slug', 'like', '%' . $filter['search'] . '%');
        }

        $query->offset($filter['start']);
        $query->limit($filter['length']);
        $query->orderBy($filter['sortBy'], $filter['sortOrder']);
        $result = $query->get();
        return $result;
    }

    /**
     * This will return page count.
     *
     * @name   getPageCount
     * @access public static
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param array $filter values for filter records
     *
     * @return void
     */
    static function getPageCount($filter)
    {
        if ($filter['search']) {
            $query  = self::where('name', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('meta_title', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('slug', 'like', '%' . $filter['search'] . '%');
            $result = $query->count();
        } else {
            $result = self::where('publish', '!=', '2')->count();
        }
        return $result;
    }

    /**
     * This will saves page details to the database.
     *
     * @name   savePageDetails
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $request - of page which you want to edit
     * @param array : $userId  - of page which you want to edit
     *
     * @return void
     */
    static function savePageDetails($request, $userId)
    {
        if (isset($request->id) && $request->id != '') {
            $userId                = Auth::id();
            $id                    = $request->id;
            $page                  = self::find($id);
            $page->name            = $request->name;
            $page->content         = $request->content;
            $page->slug            = $request->slug;
            $page->metaTitle       = $request->metaTitle;
            $page->metaKeyword     = $request->metaKeyword;
            $page->metaDescription = $request->metaDescription;
            $page->pageCategoryId  = $request->pageCategoryId;
            $page->publish         = $request->publish;
            $page->updatedBy       = $userId;
            $page->save();
        } else {
            $userId                = Auth::id();
            $page                  = new self();
            $page->name            = $request->name;
            $page->content         = $request->content;
            $page->slug            = $request->slug;
            $page->metaTitle       = $request->metaTitle;
            $page->metaKeyword     = $request->metaKeyword;
            $page->metaDescription = $request->metaDescription;
            $page->pageCategoryId  = $request->pageCategoryId;
            $page->publish         = $request->publish;
            $page->createdBy       = $userId;
            $page->updatedBy       = $userId;
            $page->save();
        }
    }

    /**
     * This will delete page created by the login users.
     *
     * @name   deletePage
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param obj $id request object to validate
     *
     * @return void
     */
    static function deletePage($id)
    {
        $userId          = Auth::id();
        $page            = self::find($id);
        $page->publish   = '2';
        $page->updatedBy = $userId;
        $page->deletedAt = date('Y-m-d h:i:s');
        $page->save();
    }

    /**
     * This will change the status of the page.
     *
     * @name   updateStatus
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $request - of page which you want to edit
     * @param array : $userId  - of page which you want to edit
     *
     * @return void
     */
    static function updateStatus($request, $userId)
    {

        if (isset($request->id) && $request->id != '') {
            $publish         = $request->publish == '1' ? '1' : '0';
            $id              = $request->id;
            $page            = self::find($id);
            $page->publish   = $publish;
            $page->updatedBy = $userId;
            $page->save();
            return $page;
        }
    }

    /**
     * This will get all the details of page created by the admin.
     *
     * @name   getPageDetails
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param array : $id - of page id which you want to edit
     *
     * @return void
     */
    static function getPageDetails($id)
    {
        return $pages = self::where('created_by', '=', $userId)->where('publish', '!=', '2')->get();
    }

}
