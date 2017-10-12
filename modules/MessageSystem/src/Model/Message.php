<?php

/**
 *  Message model
 *
 * @name       Message
 * @category   Model
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\MessageSystem\Model;

use Illuminate\Support\Facades\DB;
use App\BaseModel;

/**
 * Message model
 *
 * @category Model
 * @package  MessageSystem
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @name     Message
 * @version  Release:<v.1>
 * @link     http://www.silicus.com/
 */
class Message extends BaseModel
{

    protected $table = 'messages';

    /**
     * Create message
     *
     * @name   createMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $sender      user's id
     * @param String  $subject     message's subject
     * @param String  $messagebody message's body
     * @param String  $status      message's status
     *
     * @return void
     */
    static function createMessage($sender, $subject, $messagebody, $status)
    {
        Message::insert(['sender' => $sender, 'body' => $messagebody, 'subject' => $subject, 'status' => $status]);
        return DB::getPdo()->lastInsertId();
    }

    /**
     * Get draft unread message count
     *
     * @name   draftCount
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId User's id
     *
     * @return void
     */
    static function draftCount($userId)
    {
        return Message::where(['sender' => $userId, 'status' => 'draft'])->count();
    }

    /**
     * Getting draft messages
     *
     * @name   draftMessageList
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId User's id
     * @param String  $search Search term
     *
     * @return void
     */
    static function draftMessageList($userId, $search)
    {
        $messageList = Message::where(['sender' => $userId, 'status' => 'draft']);
        $messageList->where('subject', 'like', "%$search%");
        return $messageList->get();
    }

    /**
     * Getting send messages
     *
     * @name   sentMessageList
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId User's id
     * @param String  $search Search term
     *
     * @return void
     */
    static function sentMessageList($userId, $search)
    {
        $messageList = Message::where(['sender' => $userId, 'status' => 'sent'])
                ->orderby('updated_at', 'desc');
        $messageList->where('subject', 'like', "%$search%");
        return $messageList->get();
    }

    /**
     * Getting trash messages
     *
     * @name   trashMessageList
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId User's id
     *
     * @return void
     */
    static function trashMessageList($userId)
    {
        $trashMessages      = array ();
        $trashInboxMessages = DB::table('message_receiver')
                ->leftJoin('messages', 'messages.id', '=', 'message_receiver.message_id')
                ->where('message_receiver.status', '=', 'trash')
                ->where('receiver_id', '=', $userId)
                ->get();
        foreach ($trashInboxMessages as $record) {
            $trashMessages[] = $record;
        }
        $trashSentMessages = Message::where(['sender' => $userId, 'status' => 'trash'])->get();
        foreach ($trashSentMessages as $record) {
            $trashMessages[] = $record;
        }
        return $trashMessages;
    }

    /**
     * Getting inbox messages using id's
     *
     * @name   inboxMessageList
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId user id
     * @param String  $search search term
     *
     * @return void
     */
    static function inboxMessageList($userId, $search)
    {
        return DB::table('messages')
                        ->leftJoin('message_receiver', 'message_receiver.message_id', '=', 'messages.id')
                        ->where('message_receiver.receiver_id', '=', $userId)
                        ->where('subject', 'like', "%$search%")
                        ->whereIn('message_receiver.status', ['read', 'unread'])
                        ->orderby('message_receiver.updated_at', 'desc')
                        ->get();
    }

    /**
     * Change status as deleted for permanent delete
     *
     * @name   deleteMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array   $arrayIds messages ids
     * @param Integer $userId   user's id
     *
     * @return void
     */
    static function deleteMessage($arrayIds, $userId)
    {
        foreach ($arrayIds as $id) {
            $getStatus = Message::where(['id' => $id, 'sender' => $userId])->get();
            if (count($getStatus)) {
                if ($getStatus[0]->status == 'trash') {
                    Message::where(['id' => $id, 'sender' => $userId])->update(['status' => 'deleted']);
                }
            }
        }
    }

    /**
     * Delete draft messages
     *
     * @name   deleteDraftMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $arrayIds messages ids
     *
     * @return void
     */
    static function deleteDraftMessage($arrayIds)
    {
        foreach ($arrayIds as $id) {
            Message::where(['id' => $id])->delete();
        }
    }

    /**
     * Make sent messages as trashed
     *
     * @name   trashMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array   $arrayIds messages ids
     * @param Integer $userId   user's id
     *
     * @return void
     */
    static function trashMessage($arrayIds, $userId)
    {
        foreach ($arrayIds as $id) {
            Message::where(['id' => $id, 'sender' => $userId])->update(['status' => 'trash']);
        }
    }

    /**
     * Getting trashed messages count
     *
     * @name   trashCount
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId user's id
     *
     * @return void
     */
    static function trashCount($userId)
    {
        return Message::where(['sender' => $userId, 'status' => 'trash'])->count();
    }

    /**
     * Getting message details using message id
     *
     * @name   messageDetails
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     *
     * @return void
     */
    static function messageDetails($messageId)
    {
        return Message::where(['id' => $messageId])->get();
    }

    /**
     * Getting sender's email address
     *
     * @name   getSenderIds
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     *
     * @return void
     */
    static function getSenderIds($messageId)
    {
        $users = DB::table('users')
                ->select('email')
                ->leftJoin('messages', 'messages.sender', '=', 'users.id')
                ->where('messages.id', '=', $messageId)
                ->get();
        return $users;
    }

    /**
     * Change draft message status
     *
     * @name   sentDraftMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     *
     * @return void
     */
    static function sentDraftMessage($messageId)
    {
        Message::where(['id' => $messageId])->update(['status' => 'sent']);
    }

    /**
     * Restoreing deleted messages for sender
     *
     * @name   restoreMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     * @param Integer $userId    user's id
     *
     * @return void
     */
    static function restoreMessage($messageId, $userId)
    {
        return Message::where(['id' => $messageId, 'sender' => $userId])->update(['status' => 'sent']);
    }

}
