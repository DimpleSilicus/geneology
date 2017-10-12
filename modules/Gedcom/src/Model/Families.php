<?php
/**
 * Members class to add / edit / delete Members
 *
 * @name       Families.php
 * @category   Families
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

class Families extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'families';

    public $timestamps = false;

    /**
     * Function to add Family
     *
     * @name addFamily
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addFamily($familyName, $userId)
    {
        $objFamily = new self();
        
        $objFamily->family_name = $familyName;
        $objFamily->user_id = $userId;
        $objFamily->status = '0';
        
        $success = $objFamily->save();
        
        return $objFamily->id;
    }

    /**
     * Function to get Families by user id
     *
     * @name getFamiliesByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getFamiliesByUserId($userId)
    {
        $arrFamilies = self::select('id', 'family_name')->where('user_id', '=', $userId)
            ->where('status', '=', '0')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrFamilies;
    }

    /**
     * This will lists all the Family Search data
     *
     * @name SearchFamilyDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function SearchFamilyDetails($name, $place, $year, $genarationGap)
    {
        $result = array();
        $result = self::where('family_name', 'like', '%' . $name . '%')->orWhere('family_description', 'like', '%' . $place . '%')
            ->orWhere('family_description', 'like', '%' . $year . '%')
            ->orWhere('family_description', 'like', '%' . $genarationGap . '%')
            ->get();
        return $result;
    }

    /**
     * This will gives Family Details by Id
     *
     * @name getFamilyDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function getFamilyDetails($id)
    {
        if ('' != $id) {
            $result = array();
            $result = self::find($id);
            return $result;
        }
    }

    /**
     * parse gedcom file
     *
     * @name parseGedcomFile
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function parseGedcomFile($arrFileData)
    {
        $parser = new \PhpGedcom\Parser();
        
        // $gedcom = $parser->parse('D:\projects\Genealogy\Documents\TestGED\T2.ged');
        $gedcom = $parser->parse($arrFileData['filePath']);
        
        $ObjFamiliy = $gedcom->getFam();
        
        $ObjIndividual = $gedcom->getIndi();
        $gedcomFileId = $arrFileData["fileId"];
        
        $members = $gedcom->getIndi();
        
        $arrMembersAdded = array();
        
        // Family
        foreach ($ObjFamiliy as $family) {
            
            $arrRelations = array();
            
            // get member Data
            $familyName = $family->getId();
            
            // add family
            $familyId = Families::addFamily($familyName, Auth::id());
            
            $fatherId = null;
            $motherId = null;
            
            // parents
            $husband = $family->getHusb();
            $wife = $family->getWife();
            
            // childs
            $childs = $family->getChil();
            
            if ("" != $husband && false == array_key_exists($husband, $arrMembersAdded)) {
                
                $member = $members[$husband];
                
                $memberName = current($member->getName())->getName();
                $memberFirstName = current($member->getName())->getGivn();
                $memberLastName = current($member->getName())->getSurn();
                $memberSex = $member->getSex();
                $memberRin = $member->getRin();
                
                // $memberBirth = current($member->getName())->getBirt();
                
                $birt = current($member->getEven());
                
                if ('' == $memberFirstName) {
                    $memberFirstName = $memberName;
                }
                
                if ("" == $memberSex) {
                    $memberSex = 0;
                }
                
                $bd = current($member->getEven());
                $bdate = $bd->getDate();
                
                // add member
                $fatherId = Members::addMember(Auth::id(), $familyId, '', $memberFirstName, "father", $memberSex, $memberRin, $gedcomFileId);
                
                $arrMembersAdded[$husband] = $fatherId;
            } else if ("" != $husband) {
                $fatherId = $arrMembersAdded[$husband];
            }
            
            if ("" != $wife && false == array_key_exists($wife, $arrMembersAdded)) {
                $member = $members[$wife];
                
                $memberName = current($member->getName())->getName();
                $memberFirstName = current($member->getName())->getName();
                $memberLastName = current($member->getName())->getSurn();
                $memberSex = $member->getSex();
                $memberRin = $member->getRin();
                
                if ('' == $memberFirstName) {
                    $memberFirstName = $memberName;
                }
                
                if ("" == $memberSex) {
                    $memberSex = 1;
                }
                
                // add member
                $motherId = Members::addMember(Auth::id(), $familyId, '', $memberFirstName, "mother", $memberSex, $memberRin, $gedcomFileId);
                
                $arrMembersAdded[$wife] = $motherId;
            } else if ("" != $wife) {
                
                $motherId = $arrMembersAdded[$wife];
            }
            
            $arrRelations[] = array(
                "firstMemberId" => $fatherId,
                "secondMemberId" => $motherId,
                "relation" => "couple"
            );
            
            foreach ($childs as $key => $child) {
                if (0 < count($childs) && false == array_key_exists($child, $arrMembersAdded)) {
                    $member = $members[$child];
                    
                    $memberName = current($member->getName())->getName();
                    $memberFirstName = current($member->getName())->getName();
                    $memberLastName = current($member->getName())->getSurn();
                    $memberSex = $member->getSex();
                    $memberRin = $member->getRin();
                    
                    if ('' == $memberFirstName) {
                        $memberFirstName = $memberName;
                    }
                    
                    $childId = Members::addMember(Auth::id(), $familyId, '', $memberFirstName, "mother", $memberSex, $memberRin, $gedcomFileId);
                    
                    $arrMembersAdded[$child] = $childId;
                    
                    if ('' != $childId && '' != $fatherId) {
                        $arrRelations[] = array(
                            "firstMemberId" => $childId,
                            "secondMemberId" => $fatherId,
                            "relation" => "child"
                        );
                    }
                    
                    if ('' != $childId && '' != $motherId) {
                        $arrRelations[] = array(
                            "firstMemberId" => $childId,
                            "secondMemberId" => $motherId,
                            "relation" => "child"
                        );
                    }
                } else if (0 < count($childs)) {
                    
                    if ('' != $childId && '' != $fatherId) {
                        $arrRelations[] = array(
                            "firstMemberId" => $arrMembersAdded[$child],
                            "secondMemberId" => $fatherId,
                            "relation" => "child"
                        );
                    }
                    
                    if ('' != $childId && '' != $motherId) {
                        $arrRelations[] = array(
                            "firstMemberId" => $arrMembersAdded[$child],
                            "secondMemberId" => $motherId,
                            "relation" => "child"
                        );
                    }
                }
            }
            
            // add member relations
            if (0 < count($arrRelations)) {
                foreach ($arrRelations as $key => $relation) {
                    $relation = MemberRelations::addMemberRelation($relation["firstMemberId"], $relation["secondMemberId"], $relation["relation"]);
                }
            }
        }
        
        return true;
    }
}