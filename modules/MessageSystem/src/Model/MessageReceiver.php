<?php

/**
 * This middleware run after compleation of all other middleware.
 *
 * @name       MessageReceiver
 * @category   Model
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\MessageSystem\Model;

use App\BaseModel;
use Illuminate\Support\Facades\DB;

/**
 * Message receiver model
 *
 * @name     MessageReceiver
 * @category Model
 * @package  MessageSystem
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class MessageReceiver extends BaseModel
{

    protected $table = 'message_receiver';

    /**
     * Get inbox unread message count
     *
     * @name   inboxCount
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $userId User's id
     *
     * @return void
     */
    static function inboxCount($userId)
    {
        return MessageReceiver::where(['receiver_id' => $userId, 'status' => 'unread'])->count();
    }

    /**
     * Insert message details in receiver's table
     *
     * @name   insertMessageDetails
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId  message id
     * @param Array   $receiverId receiver's ids
     * @param String  $status     message status
     *
     * @return void
     */
    static function insertMessageDetails($messageId, $receiverId, $status)
    {
        foreach ($receiverId as $id) {
            MessageReceiver::insert(['message_id' => $messageId, 'receiver_id' => $id, 'status' => $status]);
        }
    }

    /**
     * Delete trash messages
     *
     * @name   deleteMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array   $arrayIds message id's
     * @param Integer $userId   User's id
     *
     * @return void
     */
    static function deleteMessage($arrayIds, $userId)
    {
        foreach ($arrayIds as $id) {
            $getStatus = MessageReceiver::where(['message_id' => $id, 'receiver_id' => $userId])->get();
            if (count($getStatus)) {
                if ($getStatus[0]->status == 'trash') {
                    MessageReceiver::where(['message_id' => $id, 'receiver_id' => $userId])->update(['status' => 'deleted']);
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
     * @param Array $arrayIds message id's
     *
     * @return void
     */
    static function deleteDraftMessage($arrayIds)
    {
        foreach ($arrayIds as $id) {
            MessageReceiver::where(['message_id' => $id])->delete();
        }
    }

    /**
     * Move messages to trash
     *
     * @name   trashMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array   $arrayIds message id's
     * @param Integer $userId   User's id
     *
     * @return void
     */
    static function trashMessage($arrayIds, $userId)
    {
        foreach ($arrayIds as $id) {
            MessageReceiver::where(['message_id' => $id, 'receiver_id' => $userId])->update(['status' => 'trash']);
        }
    }

    /**
     * Getting all receivers id's for message
     *
     * @name   getReceiversIds
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     *
     * @return void
     */
    static function getReceiversIds($messageId)
    {
        return DB::table('users')
                        ->select('email')
                        ->leftJoin('message_receiver', 'message_receiver.receiver_id', '=', 'users.id')
                        ->where('message_receiver.message_id', '=', $messageId)
                        ->get();
    }

    /**
     * Change read/unread status after message open
     *
     * @name   readMessageStatus
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     * @param Integer $userId    user's id
     *
     * @return void
     */
    static function readMessageStatus($messageId, $userId)
    {
        MessageReceiver::where(['message_id' => $messageId, 'receiver_id' => $userId])->update(['status' => 'read']);
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
        MessageReceiver::where(['message_id' => $messageId])->update(['status' => 'unread']);
    }

    /**
     * Restoring deleted messages for receiver
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
        MessageReceiver::where(['message_id' => $messageId, 'receiver_id' => $userId])->update(['status' => 'read']);
    }

}
