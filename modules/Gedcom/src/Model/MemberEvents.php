<?php
/**
 * MemberEvents class to add / edit / delete Member Events
 *
 * @name       MemberEvents.php
 * @category   MemberEvents
 * @package    MemberEvents
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
use Illuminate\Support\Facades\DB;

class MemberEvents extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'member_events';

    public $timestamps = false;

    /**
     * Function to add Member Events
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addMemberEvents($memberId, $arrEvents)
    {
        $arrEventData = array();
        
        if (0 < count($arrEvents)) {
            foreach ($arrEvents as $key => $event) {
                $arrEventData[] = array(
                    'event_id' => $event[1],
                    'member_id' => $memberId,
                    'event_date' => date('Y-m-d H:i:s', strtotime($event[0])),
                    'place' => $event[2]
                );
            }
        }
        
        if (0 < count($arrEventData)) {
            return self::insert($arrEventData);
        }
    }

    /**
     * Function to get Member Events
     *
     * @name getMemberEvents
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getMemberEvents($memberId)
    {
        $arrMemberEvents = self::select('members.id', 'members.first_name', DB::raw('DATE_FORMAT(member_events.event_date, "%m/%d/%Y") as event_date'), 'events.name', 'member_events.event_id', 'member_events.place')->join('members', 'members.id', '=', 'member_events.member_id')
            ->join('events', 'events.id', '=', 'member_events.event_id')
            ->where('members.status', '=', '0')
            ->where('members.id', '=', $memberId)
            ->get()
            ->toArray();
        
        return $arrMemberEvents;
    }

    /**
     * Function to delete Member Events
     *
     * @name deleteMemberEvents
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function deleteMemberEvents($memberId)
    {
        $success = true;
        $count = self::where('member_id', $memberId)->count();
        if (0 < $count) {
            $success = self::where('member_id', $memberId)->delete();
        }
        
        return $success;
    }
}
