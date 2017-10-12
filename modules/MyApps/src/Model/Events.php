<?php

/**
 * Page class to add / edit / delete Events
 *
 * @name       Appevents.php
 * @category   Model
 * @package    Event
 * @author     Swapnil Patil <SwapnilJ.Patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Model;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;

class Events extends BaseModel
{

    protected $primaryKey = 'id';

    protected $table = 'app_events';

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    /**
     * This will lists all the Events created by the user.
     *
     * @name getAllEventList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function getAllEventList($userId)
    {
        $result = array();
        $arrEvents = self::select('id', 'name', 'place', 'event_date', 'user_id as owner')->where('user_id', '=', $userId)
            ->get()
            ->toArray();
        
        $arrSharedEvents = SharedResources::getSharedEventsByUserId($userId);
        
        $arrAllEvents = array_merge($arrEvents, $arrSharedEvents);
        
        return $arrAllEvents;
    }

    /**
     * This will saves Event details to the database.
     *
     * @name saveEventDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function saveEventDetails($eventName, $eventDate, $eventPlace, $status, $userid)
    {
        $event = new self();
        $event->name = $eventName;
        $event->event_date = $eventDate;
        $event->place = $eventPlace;
        $event->status = $status;
        $event->user_id = $userid;
        $event->save();
        return back();
    }

    /**
     * This will get the event details in edit form
     *
     * @name getEventlDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param
     *            array : $id - of event id which you want to edit
     *
     * @return void
     */
    public static function getEventlDetails($id)
    {
        if ('' != $id) {
            $result = array();
            
            $result = Events::find($id);
            
            return $result;
        }
    }

    /**
     * This will update Event details to the database.
     *
     * @name UpdateEvents
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param
     *            array : $id - of Event which you want to update
     *
     * @return void
     */
    public static function UpdateEvents($id, $eventName, $eventDate, $eventPlace, $status)
    {
        if (isset($id) && $id != '') {
            $event = self::find($id);
            $event->name = $eventName;
            $event->place = $eventPlace;
            $event->status = $status;
            $event->event_date = $eventDate;
            $event->save();
            return back();
        }
    }

    /**
     * This will delete Event created by the login users.
     *
     * @name deleteEvent
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param obj $id
     *            request object to delete Event
     *
     * @return void
     */
    public static function deleteEvent($id)
    {
        $eventId = Events::find($id);
        $eventId->delete();
        return back();
    }
}
