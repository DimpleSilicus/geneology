<?php

/**
 *  Controller to add / edit / delete
 *
 * @name       GedcomController
 * @category   Plugin
 * @package    Gedcom
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Gedcom\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Modules\Gedcom\Model\Members;
use Modules\Gedcom\Model\MemberEvents;
use Modules\Gedcom\Model\MemberRelations;
use Modules\Gedcom\Model\Events;
use Modules\Gedcom\Model\GedComParser;
use Modules\Gedcom\Model\Families;
use Modules\Gedcom\Model\UserGedcomFiles;
use PhpGedcom\Gedcom;

class GedcomController extends Controller
{

    public static $jsonsting = "";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/gedcom/js/gedcom.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        parent::__construct();
    }

    public function uploadGedcom(Request $request)
    {
        
        // validate inputs
        $messages = [
            'gedcomFile.required' => 'Gedcom File is required.'
            // 'gedcomFile.mimes' => 'Please add valid picture file.'
        ];
        
        $this->validate($request, [
            'gedcomFile' => 'required'
        
        ], $messages);
        
        $file = $request->file('gedcomFile');
        
        $fileName = $file->getClientOriginalName();
        
        // upload picture
        $arrFileData = UserGedcomFiles::uploadGedcomFile($file, $fileName);
        
        // upload picture
        $upload = Families::parseGedcomFile($arrFileData);
        
        if (true == $upload) {
            echo "sssss";
            
            \Session::flash('success', 'Gedcom file uploaded successfully.');
            return \Redirect::to('gedcom/toolbox');
        }
    }

    public function gedcom()
    {
        
        // get all active events
        $arrEvents = Events::getAllActiveEvents();
        $arrFamilies = Families::getFamiliesByUserId(Auth::id());
        
        // get members
        $arrFamilyMembers = Members::getFamilyMemberByUserId(Auth::id());
        
        return view('Gedcom::upload-gedcom')->with('arrEvents', $arrEvents)
            ->with('arrFamilies', $arrFamilies)
            ->with('arrFamilyMembers', $arrFamilyMembers);
    }

    /**
     * Function is used to add pepole
     *
     * @name addPepole
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function addPepole(Request $request)
    {
        // validate inputs
        $messages = [
            'genName.required' => 'Name is required.',
            'personRelation.required' => 'Relation is required.',
            'personFamily.required' => 'Family is required.',
            'eventRowsValues.required' => 'Person data is required.',
            'generation.required' => 'Generation is required.'
        ];
        
        $this->validate($request, [
            'genName' => 'required',
            'personRelation' => 'required',
            'personFamily' => 'required',
            'eventRowsValues' => 'required',
            'generation' => 'required'
        
        ], $messages);
        
        // get gender
        if (true == in_array($request->personRelation, array(
            'father',
            'brother'
        ))) {
            $gender = 'male';
        } elseif (true == in_array($request->personRelation, array(
            'mother',
            'sister'
        ))) {
            $gender = 'female';
        }
        
        // add member
        $member = Members::addMember(Auth::id(), $request->personFamily, $request->generation, $request->genName, $request->personRelation, $gender,0);
        
        if ($member) {
            // add member relations
            $relation = MemberRelations::addMemberRelation(Auth::id(), $member, $request->personRelation);
            
            // get events
            $arrEvents = explode(',', $request->eventRowsValues);
            $arrEvent = array();
            
            if (0 < count($arrEvents)) {
                foreach ($arrEvents as $key => $event) {
                    $arrEvent[] = explode('_', $event);
                }
            }
            
            // add events
            $event = MemberEvents::addMemberEvents($member, $arrEvent);
            
            if ($event) {
                \Session::flash('success', 'Member added successfully.');
                
                return response()->json([
                    'code' => 200,
                    'success' => 'Member added successfully.'
                ]);
            } else {
                \Session::flash('success', 'Something went wrong.');
                return response()->json([
                    'code' => 400,
                    'success' => 'Something went wrong.'
                ]);
            }
        }
    }

    /**
     * Function is used to add family
     *
     * @name addFamily
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function addFamily(Request $request)
    {
        // validate inputs
        $messages = [
            'familyName.required' => 'Family Name is required.'
        ];
        
        $this->validate($request, [
            'familyName' => 'required'
        ], $messages);
        
        $family = Families::addFamily($request->familyName, Auth::id());
        
        if ($family) {
            \Session::flash('success', 'Family added successfully.');
            
            return response()->json([
                'code' => 200,
                'success' => 'Family added successfully.'
            ]);
        } else {
            \Session::flash('success', 'Something went wrong.');
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * Function is used to edit Pepole
     *
     * @name editPepole
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function editPepole(Request $request)
    {
        // validate inputs
        $messages = [
            'mid.required' => 'Member id is required.'
        ];
        
        $this->validate($request, [
            'mid' => 'required'
        ], $messages);
        
        $arrData = array();
        
        $arrMemberInfo = Members::getMemberInfoByMemberId($request->mid);
        $arrMemberEvents = MemberEvents::getMemberEvents($request->mid);
        
        $arrData['info'] = $arrMemberInfo;
        $arrData['events'] = $arrMemberEvents;
        
        return response()->json($arrData);
    }

    /**
     * Function is used to update Pepole
     *
     * @name updatePepole
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function updatePepole(Request $request)
    {
        // validate inputs
        $messages = [
            'genName.required' => 'Name is required.',
            'memId.required' => 'Member Id is required.',
            'personRelation.required' => 'Relation is required.',
            'personFamily.required' => 'Family is required.',
            'eventRowsValues.required' => 'Person data is required.'
        ];
        
        $this->validate($request, [
            'memId' => 'required',
            'genName' => 'required',
            'personRelation' => 'required',
            'personFamily' => 'required',
            'eventRowsValues' => 'required'
        
        ], $messages);
        
        // add member
        $member = Members::updateMember($request->memId, Auth::id(), $request->personFamily, $request->genName, $request->personRelation, $request->eventRowsValues);
        
        if ($member) {
            \Session::flash('success', 'Member updated successfully.');
            
            return response()->json([
                'code' => 200,
                'success' => 'Member updated successfully.'
            ]);
        } else {
            \Session::flash('success', 'Something went wrong.');
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * Function is used to delete Pepole
     *
     * @name deletePepole
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function deletePepole(Request $request)
    {
        // validate inputs
        $messages = [
            'memId.required' => 'Member Id is required.'
        ];
        
        $this->validate($request, [
            'memId' => 'required'
        ], $messages);
        
        $delete = Members::delteMemberById($request->memId);
        
        if ($delete) {
            \Session::flash('success', 'Member deleted successfully.');
        } else {
            \Session::flash('success', 'Something went wrong.');
        }
    }

    public function replaceSpecialChars(&$statement)
    {
        // replace umlauts and other special characters. Extend this list, if needed.
        $statement = str_replace("\xC3\xBC", "\xFC", $statement); // ü
        $statement = str_replace("\xC3\xB6", "\xF6", $statement); // ö
        $statement = str_replace("\xC3\x9F", "\xDF", $statement); // ß
        $statement = str_replace("\xC3\xA4", "\xE4", $statement); // ä
        $statement = str_replace("\xC3\xB3", "\xF3", $statement); // ó
        $statement = str_replace("\xC3\xA6", "\xE6", $statement); // æ
        $statement = str_replace("\xC3\xA9", "\xE9", $statement); // é
        $statement = str_replace("\xC3\x96", "\xD6", $statement); // Ö
        
        return $statement;
    }

    public function getFamilyTree(Request $request)
    {
        /*
         * // validate inputs
         * $messages = [
         * 'gedid.required' => 'Gedcom Id is required.'
         * ];
         *
         * $this->validate($request, [
         * 'gedid' => 'required'
         *
         * ], $messages);
         */
        
        // exit();
        // $arrMembers = self::getFamilyMembers($firstMem[0]['id']);
        $arrMembers = Members::select('id', 'first_name')->where('user_id', '=', Auth::id())
            ->where('gedcom_file_id', '=', 4)
            ->get()
            ->toArray();
        $arrMembersNew = array();
        // dd($arrMembers);
        foreach ($arrMembers as $key => $member) {
            
            $arrMembersNew[$member['id']] = $member;
            $arrMembersNew[$member['id']]["name"] = $member["first_name"];
        }
        
        $arrMem = array();
        $coupleId = array();
        krsort($arrMembers);
        $family = array();
        
        foreach ($arrMembersNew as $key => $member) {
            $parents = self::getParents($member['id']);
            $childs = self::getChilds($member['id']);
            
            // add parents
            if (0 < count($parents)) {
                foreach ($parents as $key2 => $parent) {
                    if (true == isset($parent["second_member_id"])) {
                        $arrMembersNew[$key]["parents"][] = $parent["second_member_id"];
                    }
                }
            } else {
                $arrMembersNew[$key]["parents"][] = 0;
            }
            // add childs
            if (0 < count($childs)) {
                foreach ($childs as $key2 => $child) {
                    if (true == isset($child["id"])) {
                        $arrMembersNew[$key]["childs"][$child["id"]] = $child["id"];
                    }
                }
            } else {
                $arrMembersNew[$key]["childs"][] = '';
            }
        }
        
        $arr_tmp = array();
        $arr_tree = array();
        
        foreach ($arrMembersNew as $key => $item) {
            if (true == isset($item["parents"]) && 0 < count($item["parents"])) {
                if (true == isset($item["parents"][0]) && 0 != $item["parents"][0]) {
                    // childs
                    if (true == isset($item["childs"]) && 0 < count($item["childs"])) {
                        foreach ($item["childs"] as $key2 => $value) {
                            
                            if (true == isset($arrMembersNew[$value])) {
                                $arrMembersNew[$key]["childs"][$value] = $arrMembersNew[$value];
                                $arrMembersNew[$key]["couple"] = $item["parents"];
                                unset($arrMembersNew[$value]);
                            }
                        }
                    }
                    // childs
                    if (true == isset($arrMembersNew[$key])) {
                        
                        $arrMembersNew[$item["parents"][0]]["childs"][$key] = $arrMembersNew[$key];
                        $arrMembersNew[$item["parents"][0]]["couple"] = $arrMembersNew[$key]["parents"];
                    }
                }
                
                unset($arrMembersNew[$key]);
            }
        }
        
        $ss = self::olLiTree($arrMembersNew);
        echo self::$jsonsting;
        exit();
        $html = view::make('Gedcom::family-tree')->with('treeHtml', self::$jsonsting);
        return $html;
        // dd($arrMembersNew);
        
        // return response()->json($arrMem);
    }

    public static function getFamilyMembers($id)
    {
        $mem = MemberRelations::select('members.first_name', 'member_relations.first_member_id', 'member_relations.second_member_id', 'member_relations.relation')->join('members', 'members.id', '=', 'member_relations.first_member_id')
            ->where('member_relations.first_member_id', '=', $id)
            ->get()
            ->toArray();
        return $mem;
    }

    public static function getChilds($parentId)
    {
        $arrChilds = MemberRelations::select('members.id', 'members.first_name', 'member_relations.first_member_id', 'member_relations.second_member_id', 'member_relations.relation')->join('members', 'members.id', '=', 'member_relations.first_member_id')
            ->where('member_relations.second_member_id', '=', $parentId)
            ->where('member_relations.relation', '=', 'child')
            ->get()
            ->toArray();
        
        return $arrChilds;
    }

    public static function getSpouses($hudbandId)
    {
        $arrChilds = MemberRelations::select('member_relations.second_member_id')->join('members', 'members.id', '=', 'member_relations.first_member_id')
            ->where('member_relations.first_member_id', '=', $hudbandId)
            ->where('member_relations.relation', '=', 'couple')
            ->get()
            ->toArray();
        
        return $arrChilds;
    }

    public static function getParents($childId)
    {
        $arrChilds = MemberRelations::select('member_relations.second_member_id')->where('member_relations.first_member_id', '=', $childId)
            ->where('member_relations.relation', '=', 'child')
            ->get()
            ->toArray();
        
        return $arrChilds;
    }

    public static function olLiTree($tree)
    {
        self::$jsonsting .= '<ul class="setHorizontalView treeHorizontalView">';
        foreach ($tree as $key => $v) {
            
            self::$jsonsting .= ' <li class="test-dropdown">
            <a data-name="s" data-age="s" data-gender="Male" data-relation="Father"  >
            <center><img src="family-tree/images/profile.png"><br>{$key}<span>s (M)</span></center>
            </a>
            <ul class="tree-action-menu">
                <li class="addModal"><a href="#">Add Member</a></li>
                <li class="viewDetailsModal"><a href="#">View Details</a></li>
                <li class="cancelBtn"><a href="#">Remove Member</a></li>
                <li class="cancelBtn"><a href="#">Cancel</a></li>
            </ul>
            ';
            
            if (true == isset($v['childs']) && false == isset($v['childs'][0])) {
                self::olLiTree($v['childs']);
                self::$jsonsting .= "</li>";
            }
        }
        self::$jsonsting .= "</ul>";
    }

    public static function olLiTreeNew($tree)
    {
        foreach ($tree as $key => $v) {
            
            self::$jsonsting .= '"li":{"a0":{"name":"' . $key . '","age":"s","gender":"Male","relation":"Father","pic":"family-tree/images/profile.png"},';
            
            if (true == isset($v['childs']) && false == isset($v['childs'][0])) {
                
                self::childs($v['childs']);
                self::$jsonsting .= "},";
            }
        }
        
        self::$jsonsting .= "}";
    }

    public static function childs($childs)
    {
        self::$jsonsting .= '"ul":{';
        foreach ($childs as $key => $v) {
            self::$jsonsting .= '"li":{"a0":{"name":"sdsd","age":"s","gender":"Male","relation":"Father","pic":"family-tree/images/profile.png"},';
            
            if (true == isset($v['childs']) && false == isset($v['childs'][0])) {
                self::childs($v['childs']);
            }
            self::$jsonsting .= "},";
        }
        self::$jsonsting .= '},';
    }
}