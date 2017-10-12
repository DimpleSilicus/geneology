<?php
/**
 * Members class to add / edit / delete Members
 *
 * @name       Members.php
 * @category   Members
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
use App\simpleGMapAPI;
use Illuminate\Support\Facades\DB;
use Modules\Profile\Model\UserNetwork;

class Members extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'members';

    public $timestamps = false;

    /**
     * Function to add members
     *
     * @name addMember
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addMember($userId, $familyId, $generation, $genName, $personRelation, $gender, $rin, $gedcomFileId = null)
    {
        $objMember = new self();
        
        if ("" == $gender) {
            $gender = "M";
        }
        
        $objMember->family_id = $familyId;
        $objMember->first_name = $genName;
        $objMember->last_name = NULL;
        $objMember->user_id = $userId;
        $objMember->user_id = $userId;
        $objMember->gedcom_file_id = $gedcomFileId;
        $objMember->generation = $generation;
        $objMember->gender = $gender;
        $objMember->avatar = NULL;
        $objMember->notes = NULL;
        $objMember->privacy = '0';
        $objMember->status = '0';
        $objMember->type = '0';
        $objMember->rin = $rin;
        
        $success = $objMember->save();
        
        return $objMember->id;
    }

    /**
     * Function to add members
     *
     * @name addMember
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function updateMember($memberId, $userId, $familyId, $genName, $personRelation, $events)
    {
        
        // update memeber information
        $objMember = self::find($memberId);
        
        $objMember->family_id = $familyId;
        $objMember->first_name = $genName;
        $objMember->last_name = null;
        $objMember->user_id = $userId;
        
        $success = $objMember->save();
        
        if ($success) {
            // update relation
            $objExMemberRelation = MemberRelations::select('id')->where('first_member_id', '=', $userId)
                ->where('second_member_id', '=', $memberId)
                ->get();
            
            $memberRelationId = $objExMemberRelation[0]->id;
            
            $objMemberRelation = MemberRelations::find($memberRelationId);
            
            $objMemberRelation->relation = $personRelation;
            
            $objMemberRelation->save();
            
            // delete events
            
            $delete = MemberEvents::deleteMemberEvents($memberId);
            
            if ($delete) {
                // add events
                $arrEvents = explode(',', $events);
                $arrEvent = array();
                
                if (0 < count($arrEvents)) {
                    foreach ($arrEvents as $key => $event) {
                        $arrEvent[] = explode('_', $event);
                    }
                }
                
                // add events
                $event = MemberEvents::addMemberEvents($memberId, $arrEvent);
                
                return $event;
            }
        }
    }

    /**
     * Function to get family members by user id
     *
     * @name addMember
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getFamilyMemberByUserId($userId)
    {
        $arrFamilyMember = self::select('id', 'first_name', 'generation')->where('user_id', '=', $userId)
            ->where('status', '=', '0')
            ->where('generation', '<>', null)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        
        $arrData = array();
        if (0 < count($arrFamilyMember)) {
            foreach ($arrFamilyMember as $key => $memeber) {
                $arrData[$memeber['generation']][] = array(
                    'id' => $memeber['id'],
                    'name' => $memeber['first_name']
                );
            }
        }
        
        return $arrData;
    }

    /**
     * Function to get Member Info
     *
     * @name getMemberInfoByMemberId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getMemberInfoByMemberId($memberId)
    {
        $arrMemberInfo = self::select('members.id', 'members.first_name', 'member_relations.relation', 'members.family_id')->join('member_relations', 'member_relations.second_member_id', '=', 'members.id')
            ->where('members.status', '=', '0')
            ->where('members.id', '=', $memberId)
            ->get()
            ->toArray();
        
        return $arrMemberInfo;
    }

    /**
     * Function to get delet member
     *
     * @name getMemberInfoByMemberId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function delteMemberById($memberId)
    {
        $success = false;
        
        if ('' != $memberId) {
            $objMember = self::find($memberId);
            $objMember->status = '1';
            
            $success = $objMember->save();
        }
        
        return $success;
    }
    
    
    /**
     * This will lists all the Member Search data
     *
     * @name   SearchMemberDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function SearchMemberDetails($name,$place,$year,$genarationGap)
    {
        $result = array();
        
        $query =  DB::table("members")
        ->select(DB::raw('id,family_id,first_name,last_name,user_id,notes,place,bdate'))
        ->where('last_name','like','%'.$name.'%');
        
        if(!empty($place))
        {
            $query -> Where('place','like','%'.$place.'%');
        } 
        
        if(!empty($year))
        {
            $query -> orWhere('bdate','like','%'.$year.'%');
        } 
        
        if(!empty($genarationGap))
        {
            $query -> orWhere('generation','=',$genarationGap);
        } 
        
        $result = $query ->get()->toArray();
        return $result;
    }
    
    /**
     * This will gives Member Details by user_id
     *
     * @name   getMemberInfo
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function getMemberInfo($id)
    {
        if('' != $id)
        {
            $result = array();
            $result = self::where('user_id',$id)->first();
            return $result;
        }
    }	  
    
    /**
     * Function to get search result of world map
     *
     * @name searchWorldMap
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */    
    
    public function searchWorldMap($place,$name,$bdate,$year)
    {
        // get family id by userid
        $getFamilyId = array();
        $userId = Auth::id();
        $getFamilyId = Members::where('user_id','=',$userId)->first();
        $familyID = $getFamilyId['family_id'];
        
        $result = array();
        $newDate =  date("Y-m-d", strtotime($bdate));
        
        // query to get search result of world map
        $query =  DB::table("members")
        ->select(DB::raw('COUNT(members.place) count,members.id,members.family_id,members.first_name,members.last_name,members.user_id,members.notes,members.place,members.bdate'))
        ->where('place','!=','')
        ->groupBy('place')
        ->havingRaw('COUNT(*) >= 1');
        //->where('family_id','=',$familyID)

        

        if(!empty($place))
        {
            $query -> Where('place','like','%'.$place.'%');
        }        
       
        if(!empty($name))
        {
            $query -> orWhere('first_name','like','%'.$name.'%');
        }
        
        if(!empty($name))
        {
            $query -> orWhere('last_name','like','%'.$name.'%');
        }
        
        
        if(!empty($newDate))
        {
            $query -> orWhere('bdate','like','%'.$newDate.'%');
        }
        
        if(!empty($year))
        {
            $query -> orWhere('bdate','like','%'.$year.'%');
        } 
       
        $result = $query ->get()->toArray();
        
      
        // If search result is zero then execute below query to display world map
        if(count($result)==0)
        {
            $query =  DB::table("members")
            ->select(DB::raw('COUNT(members.place) count,members.id,members.family_id,members.first_name,members.last_name,members.user_id,members.notes,members.place,members.bdate'))
            ->where('place','!=','')
            ->groupBy('place')
            ->havingRaw('COUNT(*)>= 1')
            //->where('family_id','=',$familyID)
            ->get()->toArray();
        }
        
          
        $map = new simpleGMapAPI(); //  object of class simpleGMapAPI
        $map->setWidth('100%');
        $map->setHeight('800px');
        $map->setBackgroundColor('#000');
        $map->setMapDraggable(true);
        $map->setDoubleclickZoom(true);
        $map->setScrollwheelZoom(true);
        $map->showDefaultUI(true);
        $map->showMapTypeControl(true, 'DROPDOWN_MENU');
        $map->showNavigationControl(true, 'DEFAULT');
        $map->showScaleControl(true);
        $map->showStreetViewControl(true);
        $map->setZoomLevel(6); // not really needed because showMap is called in this demo with auto zoom
        $map->setInfoWindowBehaviour('SINGLE_CLOSE_ON_MAPCLICK');
        $map->setInfoWindowTrigger('CLICK');
        $locations=array();
        $host = request()->getHttpHost();

        foreach($result as $row)
        {
            $place = $row->place;
            $count =  $row->count;
            $description =  $count; 
                       
            $map->addMarkerByAddress($place , $count, '<h3>'.$place.'</h3><p>'.$description.'</p>',"http://$host/theme/skyblue/images/group.png");
            
        }
        
        $map->printGMapsJS();   // to call map function
        $map->showMap(true);    // to display map
        
    }  	
    
    
    /**
     * Function to get world map
     *
     * @name getWorldMap
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */   
    public function getWorldMap()
    {
 
        // get family id by userid
        $getFamilyId = array();
        $userId = Auth::id();
        $getFamilyId = Members::where('user_id','=',$userId)->first();
        $familyID = $getFamilyId['family_id'];

        // query to get world map 
        $result = array();
        $result =  DB::table("members")->select(DB::raw('COUNT(members.place) count,members.id,members.family_id,members.first_name,members.last_name,members.user_id,members.notes,members.place,members.bdate'))
        ->where('place','!=','')
        ->groupBy('place')
        ->havingRaw('COUNT(*) >= 1')
        //->where('family_id','=',$familyID)
        ->get()->toArray();
  
        $map = new simpleGMapAPI(); //  object of class simpleGMapAPI
        $map->setWidth('100%');
        $map->setHeight('800px');
        $map->setBackgroundColor('#000');
        $map->setMapDraggable(true);
        $map->setDoubleclickZoom(true);
        $map->setScrollwheelZoom(true);
        $map->showDefaultUI(true);
        $map->showMapTypeControl(true, 'DROPDOWN_MENU');
        $map->showNavigationControl(true, 'DEFAULT');
        $map->showScaleControl(true);
        $map->showStreetViewControl(true);
        $map->setZoomLevel(6); // not really needed because showMap is called in this demo with auto zoom
        $map->setInfoWindowBehaviour('SINGLE_CLOSE_ON_MAPCLICK');
        $map->setInfoWindowTrigger('CLICK');
        $locations=array();
        $host = request()->getHttpHost();
        
        foreach($result as $row)
        {
            $place = $row->place;
            $count =  $row->count;
            $description =  $count;       
            $map->addMarkerByAddress($place , $count, '<h3>'.$place.'</h3><p>'.$description.'</p>',"http://$host/theme/skyblue/images/group.png");            
        }
        
        
        $map->printGMapsJS();   // to call map function
        $map->showMap(true);    // to display map
        
    }  	
    
    
    /**
     * Function to get search result of world map
     *
     * @name searchWorldMap
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    
    public function searchPersonalMap($place)
    {
        
        $getFamilyId = array();
        $userId = Auth::id();
        $getFamilyId = Members::where('user_id','=',$userId)->first();
        $familyID = $getFamilyId['family_id'];
        
        $result = array();
        
        if(!empty($place))
        {    
        $result = Members::select('members.id','members.family_id','members.first_name','members.last_name','members.user_id','members.notes','members.place','members.bdate','members.gedcom_file_id')
        ->where('place','!=','')
        ->where('gedcom_file_id','=',$place)
        ->get()->toArray();
        }
        else 
        {
        $result = Members::select('members.id','members.family_id','members.first_name','members.last_name','members.user_id','members.notes','members.place','members.bdate','members.gedcom_file_id')
        ->where('family_id','=',$familyID)
        ->get()->toArray();
        }
        
        
        
        if(count($result)==0)
        {
            $result = Members::select('members.id','members.family_id','members.first_name','members.last_name','members.user_id','members.notes','members.place','members.bdate','members.gedcom_file_id')
            ->where('family_id','=',$familyID)
            ->get()->toArray();
        }
        
        $map = new simpleGMapAPI(); //  object of class simpleGMapAPI
        $map->setWidth('100%');
        $map->setHeight('800px');
        $map->setBackgroundColor('#000');
        $map->setMapDraggable(true);
        $map->setDoubleclickZoom(true);
        $map->setScrollwheelZoom(true);
        $map->showDefaultUI(true);
        $map->showMapTypeControl(true, 'DROPDOWN_MENU');
        $map->showNavigationControl(true, 'DEFAULT');
        $map->showScaleControl(true);
        $map->showStreetViewControl(true);
        $map->setZoomLevel(6); // not really needed because showMap is called in this demo with auto zoom
        $map->setInfoWindowBehaviour('SINGLE_CLOSE_ON_MAPCLICK');
        $map->setInfoWindowTrigger('CLICK');
        $host = request()->getHttpHost();
        $locations=array();
        
 
        foreach($result as $data)
        {
            $place = $data['place'];          
            $member = $data['first_name']." ".$data['last_name']." , ".$place;
            $description =  $data['notes'];      
            $map->addMarkerByAddress($place , $member, '<h3>'.$member.'</h3><p>'.$description.'</p>',"http://$host/theme/skyblue/images/personal.png");
        }        
       
        $map->printGMapsJS();   // to call map function
        $map->showMap(true);    // to display map
        
    }  	
    
    /**
     * Function to get Personal map
     *
     * @name getPersonalMap
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */ 
    public function getPersonalMap()
    {
        $getFamilyId = array();
        $userId = Auth::id();
        $getFamilyId = Members::where('user_id','=',$userId)->first();
        $familyID = $getFamilyId['family_id'];
        
        $result = array();
        $result = Members::select('members.id','members.family_id','members.first_name','members.last_name','members.user_id','members.notes','members.place','members.bdate')
        ->where('family_id','=',$familyID)
        ->where('place','!=','')
        ->get()->toArray();
      
        $map1 = new simpleGMapAPI(); //  object of class simpleGMapAPI
        $map1->setWidth('100%');
        $map1->setHeight('800px');
        $map1->setBackgroundColor('#000');
        $map1->setMapDraggable(true);
        $map1->setDoubleclickZoom(true);
        $map1->setScrollwheelZoom(true);
        $map1->showDefaultUI(true);
        $map1->showMapTypeControl(true, 'DROPDOWN_MENU');
        $map1->showNavigationControl(true, 'DEFAULT');
        $map1->showScaleControl(true);
        $map1->showStreetViewControl(true);
        $map1->setZoomLevel(6); // not really needed because showMap is called in this demo with auto zoom
        $map1->setInfoWindowBehaviour('SINGLE_CLOSE_ON_MAPCLICK');
        $map1->setInfoWindowTrigger('CLICK');
        $locations1 =array();
        $host = request()->getHttpHost();
        
        foreach($result as $data)
        {
            $place =  $data['place'];
            $member = $data['first_name']." ".$data['last_name']." , ".$place;
            $description =  $data['notes'];
            
            $geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$place&sensor=false");
            $output_deals = json_decode($geocode_stats);
            $latLng = $output_deals->results[0]->geometry->location;
            $lat = $latLng->lat;
            $lng = $latLng->lng;
            
            $map1->addMarker($lat ,  $lng , $member, '<h3>'.$member.'</h3><p>'.$description.'</p>',"http://$host/theme/skyblue/images/personal.png"); 
            //$map1->addMarkerByAddress($place , $member, '<h3>'.$member.'</h3><p>'.$description.'</p>',"http://$host/theme/skyblue/images/personal.png");
            
            // Each row is added as a new array
            $locations1[]=array('name1'=>$place,'lat1'=>$lat,'lng1'=>$lng);
        }
        
        $map1->printGMapsJS1();   // to call map function
        $map1->showMap(true);     // to display map
    }  	
    
    
    /**
     * Function to get member gedcom countries 
     *
     * @name getMemberCountries
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function getMemberCountries()
    {
        $userId = Auth::id();
        $getFamilyId = Members::where('user_id','=',$userId)->first();
        $familyID = $getFamilyId['family_id'];
        
        $result = array();
        $result = Members::select('id','family_id','place')
        ->where('family_id','=',$familyID)
        ->where('place','!=','')
        ->groupBy('place')
        ->get()->toArray();
        return $result;        
    }
    
    
    
}