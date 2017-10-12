<?php
/**
 * MemberRelations class to add / edit / delete Member Relations
 *
 * @name       MemberRelations.php
 * @category   MemberRelations
 * @package    Profile
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\Gedcom\Model;

use Illuminate\Database\Eloquent\Model;

class MemberRelations extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'member_relations';

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
    public static function addMemberRelation($firstMemberId, $secondMemberId, $relation)
    {
        $objMemberRelation = new self();
        
        $objMemberRelation->first_member_id = $firstMemberId;
        $objMemberRelation->second_member_id = $secondMemberId;
        $objMemberRelation->relation = $relation;
        
        $success = $objMemberRelation->save();
        
        return $success;
    }
}
