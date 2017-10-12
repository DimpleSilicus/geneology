<?php

/**
 *  Description
 *
 * @name       Name
 * @category   Category
 * @package    Package
 * @author     Swati Jadhav <swati.jadhav@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\@USample@;

use Illuminate\Database\Eloquent\Model;

/**
 * Class description
 *
 * @name     @USample@
 * @category Model
 * @package  @USample@
 * @author   Swati Jadhav <swati.jadhav@silicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class @USample@ extends Model
{

    /**
     * Table name
     *
     * @var string
     */
    protected $table = '@TableName@';

    /**
     * Set fillable fields
     *
     * @var array
     */
    protected $fillable = [@Fillable@];

    /**
     * Set validation rules
     *
     * @var array
     */
    public static $rules = [@Rules@];

    @MEMBER_VARIABLES@

    @GETTER_FUNC@
    /**
     * This will create new entery into @USample@
     *
     * @name   MethodName
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array $request input array
     *
     * @return void
     */
    public static function store($request)
    {
        @USample@::create($request);
    }

    /**
     * Search in module
     *
     * @name   searchByAll
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $searchTerm input string
     *
     * @return void
     */
    public static function searchByAll($searchTerm)
    {
        $@LSample@ = @SEARCH_CONTENT@;

        return $@LSample@;
    }

    /**
     * Create record
     *
     * @name   createRecord
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array $input input array
     *
     * @return void
     */
    public static function createRecord($input)
    {
        @USample@::create($input);
    }

    /**
     * Update record
     *
     * @name   updateRecord
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param int   $id    record id
     * @param array $input input array
     *
     * @return void
     */
    public static function updateRecord($id, $input)
    {
        $@LSample@ = @USample@::find($id);
        $@LSample@->update($input);
    }

    /**
     * Delete record
     *
     * @name   deleteRecord
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param int $id record id
     *
     * @return void
     */
    public static function deleteRecord($id)
    {
        @USample@::find($id)->delete();
    }

    /**
     * Paginate record
     *
     * @name   paginateRecords
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @return $contact record set
     */
    public static function paginateRecords()
    {
        $@LSample@ = @USample@::paginate(5);
        return $@LSample@;
    }

}
