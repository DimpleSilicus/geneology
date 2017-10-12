<?php

/**
 * Page class to add / edit / delete Journals
 *
 * @name       Journal.php
 * @category   Model
 * @package    Journal
 * @author     Swapnil Patil <SwapnilJ.Patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */
namespace Modules\MyApps\Model;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;
use Modules\Profile\Model\UserNetwork;
use Illuminate\Support\Facades\DB;

class Journal extends BaseModel
{

    protected $primaryKey = 'id';

    protected $table = 'journals';

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * This will lists all the Journals created by the user.
     *
     * @name getAllJournal
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function getAllJournal($userId)
    {
        $arrJournal = self::select('journals.id', 'journals.name', 'journals.description', 'journals.user_id as owner','journals.user_id as uid')
            ->where('journals.user_id', '=', $userId)
            ->where('journals.status', '<>', '2')
            ->orderBy('journals.created_at', 'desc')
            ->get()
            ->toArray();             
            
        $arrSharedJournals = SharedResources::getSharedJournalsByUserId($userId);
        $arrAllJournals = array_merge($arrJournal, $arrSharedJournals);
        $arrNetworkUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
       
        return $arrAllJournals;

       
    }

    /**
     * This will saves Journal details to the database.
     *
     * @name saveJournalDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    public static function saveJournalDetails($name, $description, $status, $userid)
    {
        $journal = new self();
        $journal->name = $name;
        $journal->description = $description;
        $journal->status = $status;
        $journal->user_id = $userid;
        $journal->save();
        return back();
    }

    /**
     * This will get the journal details in edit form
     *
     * @name getJournalDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param
     *            array : $id - of journal id which you want to edit
     *
     * @return void
     */
    public static function getJournalDetails($id)
    {
        if ('' != $id) {
            $result = array(); 
            $result = Journal::find($id);        
            return $result;
        }
    }

    /**
     * This will update Journal details to the database.
     *
     * @name UpdateJournal
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param
     *            array : $id - of journal which you want to edit
     *
     * @return void
     */
    public static function UpdateJournal($id, $title, $description, $status, $userid)
    {
        if (isset($id) && $id != '') {
            $journal = self::find($id);
            $journal->name = $title;
            $journal->description = $description;
            $journal->status = $status;
            $journal->user_id = $userid;
            $journal->save();
            return back();
        }
    }

    /**
     * This will delete Journal created by the login users.
     *
     * @name deleteJournal
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param obj $id
     *            request object to delete journal
     *
     * @return void
     */
    public static function deleteJournal($id)
    {
        $journalId = Journal::find($id);
        $journalId->delete();
        return back();
    }
}
