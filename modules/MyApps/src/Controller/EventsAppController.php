<?php

/**
 *  Controller to add / edit / delete Events
 *
 * @name       EventsAppController
 * @category   Controller
 * @package    Event
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Modules\MyApps\Model\Events;
use Modules\MyApps\Model\SharedResources;
use Modules\Profile\Model\UserNetwork;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class EventsAppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/myapps/js/event-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        parent::__construct();
    }

    /**
     * This will delete Event record created by the user.
     * Only owner of Event can be delete his own Event
     *
     * @name deleteEventRecord
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *         @paarmeter $id used to delete events
     * @return void
     */
    public function deleteEventRecord(Request $request)
    {
        $id = $request->id;
        $deleteEvent = Events::deleteEvent($id);
        if ($deleteEvent) {
            \Session::flash('success', 'Event deleted successfully .');
        }
    }

    /**
     * This will display Event List data
     *
     * @name getEventList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getEventList()
    {
        $arrEvents = array();
        $arrNetworkUsers = array();
        $arrEvents = Events::getAllEventList(Auth::id());
        $arrNetworkUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
        $html = view::make('MyApps::event-app.list-events', compact('arrEvents', 'arrNetworkUsers'))->render();
        
        return $html;
    }

    /**
     * This will save new Event
     *
     * @name saveNewEventDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function saveNewEventDetails(Request $request)
    {
        
        // validate inputs
        $messages = [
            'Eventname.required' => 'Event Name is required.',
            'Date.required' => 'Event Date is required.',
            'Place.required' => 'Event Place is required.'
        ];
        
        $this->validate($request, [
            'Eventname' => 'required',
            'Date' => 'required',
            'Place' => 'required'
        ], $messages);
        
        $eventName = $request->Eventname;
        $eventPlace = $request->Place;
        $status = '0';
        $Date = $request->Date;
        $eventDate = date("Y-m-d", strtotime($Date));
        $userid = Auth::id();
        $addEvent = Events::saveEventDetails($eventName, $eventDate, $eventPlace, $status, $userid);
        if ($addEvent) {
            \Session::flash('success', 'Event added successfully .');
        }
    }

    /**
     * This will get edit Event details into edit form
     *
     * @name editEvents
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function editEvents(Request $request)
    {
        $id = $request->id;
        $arrEvents = array();
        $arrEvents = Events::getEventlDetails($id);
        return response()->json($arrEvents);
        return view('event-app::list')->with('eventDetails', $arrEvents);
    }

    /**
     * This will update existing Event details.
     * Only owner of Event can be update his own Events
     *
     * @name UpdateEventDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function UpdateEventDetails(Request $request)
    {
        // validate inputs
        $messages = [
            'Eventname.required' => 'Event Name is required.',
            'Date.required' => 'Event Date is required.',
            'Place.required' => 'Event Place is required.'
        ];
        
        $this->validate($request, [
            'Eventname' => 'required',
            'Date' => 'required',
            'Place' => 'required'
        ], $messages);
        
        $id = $request->id;
        $eventName = $request->Eventname;
        $eventPlace = $request->Place;
        $status = '0';
        $Date = $request->Date;
        $eventDate = date("Y-m-d", strtotime($Date));
        
        if (! empty($id)) {
            $updateEvent = Events::UpdateEvents($id, $eventName, $eventDate, $eventPlace, $status);
            if ($updateEvent) {
                \Session::flash('success', 'Event update successfully .');
            }
        }
    }

    /**
     * This will get Event id details into row wise
     *
     * @name getEventDetailsForNetwork
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getEventDetailsForNetwork(Request $request)
    {
        $arrEventRow = array();
        $id = $request->id;
        $arrEventRow = Events::getEventlDetails($id);
        return response()->json($arrEventRow);
        return view('event-app::list')->with('eventRowDetails', $arrEventRow);
    }

    /**
     * This will Shared Event details to user Network.
     *
     * @name ShareEventOnNetwork
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function ShareEventOnNetwork(Request $request)
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/profile/js/profile.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        $resourceId = $request->resourceId;
        $resourceType = 'Event';
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        $sharedTo = '';
        $shareEvent = SharedResources::shareResourceOnNetwork($resourceId, $resourceType, $sharedBy, $recieverStatus, $sharedTo);
        if ($shareEvent) {
            \Session::flash('success', 'Event shared on network successfully .');
        }
    }

    /**
     * This will Shared Event details to user Network.
     *
     * @name ShareEventToPerson
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function ShareEventToPerson(Request $request)
    {
        $resourceId = $request->resourceId;
        $resourceType = 'Event';
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        $sharedTo = $request->shareTo;
        $shareEvent = SharedResources::shareSingleResource($resourceId, $resourceType, $sharedBy, $recieverStatus, $sharedTo);
        if ($shareEvent) {
            \Session::flash('success', 'Event shared successfully .');
        }
    }
}
