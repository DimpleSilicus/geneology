<?php

/**
 *  Controller to add / edit / delete Journals
 *
 * @name       JournalAppController
 * @category   Controller
 * @package    Journal
 * @author     Amol Savat <amol.savat@silicus.com>
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
use Modules\MyApps\Model\Journal;
use Modules\MyApps\Model\SharedResources;
use Modules\Profile\Model\UserNetwork;
use Modules\Profile\Model\UserPrivacy;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class JournalAppController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/myapps/js/journal-app.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        parent::__construct();
    }

    public function getMyNetwork()
    {
        return view('MyApps::my-apps');
    }

    /**
     * This will display Journal List data
     *
     * @name getJournalList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getJournalList()
    {
        $arrNetworkUsers = array();
        $arrJournal = array();
        $arrJournal = Journal::getAllJournal(Auth::id());
        $arrNetworkUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
        $html = view::make('MyApps::journal-app.list-journal', compact('arrJournal', 'arrNetworkUsers'))->render();
        return $html;
    }

    /**
     * This will delete Journal record created by the user.
     * Only owner of journal can be delete his own journal
     *
     * @name deleteJournalRecord
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *         @paarmeter $id used to delete record
     * @return void
     */
    public function deleteJournalRecord(Request $request)
    {
        $id = $request->id;
        $deleteJournal = Journal::deleteJournal($id);
        if ($deleteJournal) {
            \Session::flash('success', 'Journal deleted successfully .');
        }
    }

    /**
     * This will save new Journal
     *
     * @name saveJournal
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function saveJournal(Request $request)
    {
        
        // validate inputs
        $messages = [
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.'
        ];
        
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        
        ], $messages);
        
        $name = $request->title;
        $description = $request->description;
        $status = '0';
        $userid = Auth::id();
        $addJournal = Journal::saveJournalDetails($name, $description, $status, $userid);
        if ($addJournal) {
            \Session::flash('success', 'Journal added successfully .');
        }
    }

    /**
     * This will get edit Journal details into edit form
     *
     * @name editJournal
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function editJournal(Request $request)
    {
        $arrJournals = array();
        $id = $request->id;
        $arrJournals = Journal::getJournalDetails($id);
        return response()->json($arrJournals);
        return view('journal-app::list')->with('journalDetails', $arrJournals);
    }

    /**
     * This will update existing Journal details.
     * Only owner of journal can be update his own journal
     *
     * @name UpdateJournalDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function UpdateJournalDetails(Request $request)
    {
        // validate inputs
        $messages = [
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.'
        ];
        
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        
        ], $messages);
        
        $title = $request->title;
        $description = $request->description;
        $id = $request->id;
        $status = '0';
        $userid = Auth::id();
        if (! empty($id)) {
            $updateJournal = Journal::UpdateJournal($id, $title, $description, $status, $userid);
            if ($updateJournal) {
                \Session::flash('success', 'Journal update successfully .');
            }
        }
    }

    /**
     * This will get Journal details into row wise
     *
     * @name editJournal
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getJournalInDetailsForNetwork(Request $request)
    {
        $arrJournalsRow = array();
        $id = $request->id;
        $arrJournalsRow = Journal::getJournalDetails($id);
        return response()->json($arrJournalsRow);
        return view('journal-app::list')->with('journalRowDetails', $arrJournalsRow);
    }

    /**
     * This will Shared Journal details to user Network.
     *
     * @name SharedJournalOnNetwork
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function SharedJournalOnNetwork(Request $request)
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/profile/js/profile.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        $resourceId = $request->resourceId;
        $resourceType = 'Journal';
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        $sharedTo = '';
        $shareJournals = SharedResources::shareResourceOnNetwork($resourceId, $resourceType, $sharedBy, $recieverStatus, $sharedTo);
        if ($shareJournals) {
            \Session::flash('success', 'Journal shared on network successfully .');
        }
    }

    /**
     * This will Shared Journal details to user Network.
     *
     * @name ShareJournalToPerson
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function ShareJournalToPerson(Request $request)
    {
        $resourceId = $request->resourceId;
        $resourceType = 'Journal';
        $sharedBy = Auth::id();
        $recieverStatus = '0';
        $sharedTo = $request->shareTo;
        $shareJournals1 = SharedResources::shareSingleResource($resourceId, $resourceType, $sharedBy, $recieverStatus, $sharedTo);
        if ($shareJournals1) {
            \Session::flash('success', 'Journal shared successfully .');
        }
    }
    
    /**
     * This will get Journal Module Settings by Login User
     *
     * @name getModulePrivacySettings
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getModulePrivacySettings()
    {
        $privacySettings = array();
        $userId = Auth::id();
        $module = 'journals';
        $privacySettings = UserPrivacy::getPrivacySettingsByModule($userId,$module);
        return response()->json($privacySettings);
        return view('journal-app::list')->with('privacySettings', $privacySettings);
    }
}
