<?php

/**
 *  Controller for message system
 *
 * @name       MessageController
 * @category   Controller
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\MessageSystem\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Modules\MessageSystem\Model\User;
use Modules\MessageSystem\Model\Message;
use Modules\MessageSystem\Model\MessageReceiver;
use Illuminate\Support\Facades\Session;
use Auth;

/**
 * MessageController Controller class
 *
 * @name     MessageController
 * @category Controller
 * @package  MessageSystem
 * @author   Vivek Bansal <vivek.bansal@silicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class MessageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $cssFiles[] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css";
        $cssFiles[] = $this->url . '/theme/' . $this->theme . '/assets/MessageSystem/css/front.css';
        $jsFiles[]  = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js";
        $jsFiles[]  = $this->url . '/theme/' . $this->theme . '/assets/MessageSystem/js/front.js';
        $this->loadJsCSS($jsFiles, $cssFiles);
    }

    /**
     * Insert new message into database
     *
     * @name   createMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Request $request submit request
     *
     * @return void
     */
    public function createMessage(Request $request)
    {
        $userId     = Auth::user()->id;
        $inboxCount = MessageReceiver::inboxCount($userId);
        $draftCount = Message::draftCount($userId);
        $usersList  = User::getUserList();
        if ($request->method() == 'POST') {
            $receiver             = (array) $request->receiver;
            $subject              = $request->subject;
            $messagebody          = $request->messagebody;
            $this->validate($request, [
                'subject'     => 'required',
                'receiver'    => 'required',
                'messagebody' => 'required',
            ]);
            $status               = (Input::get('status') == '' ? 'sent' : Input::get('status'));
            $messageId            = Message::createMessage($userId, $subject, $messagebody, $status);
            $status               = (Input::get('status') == '' ? 'unread' : Input::get('status'));
            $insertMessageDetails = MessageReceiver::insertMessageDetails($messageId, $receiver, $status);
            if ($messageId) {
                if ($request->ajax()) {
                    return json_encode(['message' => 'success']);
                }
                return redirect('/messages/inbox')->with('successMessage', 'Message sent successfully.');
            } else {
                return redirect('/messages/create')->with('errorMessage', 'Please try again.');
            }
        }
        return view('ms::create')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('usersList', $usersList);
    }

    /**
     * Draft message
     *
     * @name   draftMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function draftMessage()
    {
        $userId           = Auth::user()->id;
        $inboxCount       = MessageReceiver::inboxCount($userId);
        $draftCount       = Message::draftCount($userId);
        $search           = (Input::get('search') != '') ? (Input::get('search')) : '';
        $draftMessageList = Message::draftMessageList($userId, $search);
        return view('ms::draft')
                        ->with('folderName', 'Drafts')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('messageList', $draftMessageList);
    }

    /**
     * Mark message as sent in database
     *
     * @name   sentMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function sentMessage()
    {
        $userId          = Auth::user()->id;
        $inboxCount      = MessageReceiver::inboxCount($userId);
        $draftCount      = Message::draftCount($userId);
        $search          = (Input::get('search') != '') ? (Input::get('search')) : '';
        $sentMessageList = Message::sentMessageList($userId, $search);
        return view('ms::sent')
                        ->with('folderName', 'Sent')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('messageList', $sentMessageList);
    }

    /**
     * Mark message as trash in database
     *
     * @name   trashMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function trashMessage()
    {
        $userId           = Auth::user()->id;
        $inboxCount       = MessageReceiver::inboxCount($userId);
        $draftCount       = Message::draftCount($userId);
        $trashMessageList = Message::trashMessageList($userId);
        return view('ms::trash')
                        ->with('folderName', 'Trash')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('messageList', $trashMessageList);
    }

    /**
     * Inbox message
     *
     * @name   inboxMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @return void
     */
    public function inboxMessage()
    {
        $userId           = Auth::user()->id;
        $search           = (Input::get('search') != '') ? (Input::get('search')) : '';
        $inboxCount       = MessageReceiver::inboxCount($userId);
        $draftCount       = Message::draftCount($userId);
        $inboxMessageList = Message::inboxMessageList($userId, $search);
        return view('ms::inbox')
                        ->with('folderName', 'Inbox')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('messageList', $inboxMessageList);
    }

    /**
     * Mark message as deleted (soft delete)
     *
     * @name   deleteMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $arrayIds message id's
     *
     * @return void
     */
    public function deleteMessage($arrayIds)
    {
        $userId                = Auth::user()->id;
        $arrayIds              = explode(',', $arrayIds);
        $deleteMessage         = Message::deleteMessage($arrayIds, $userId);
        $deleteMessageReceiver = MessageReceiver::deleteMessage($arrayIds, $userId);
        return redirect('/messages/trash')->with('successMessage', 'Message deleted successfully.');
    }

    /**
     * Delete message permanently
     *
     * @name   deleteDraftMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $arrayIds message id's
     *
     * @return void
     */
    public function deleteDraftMessage($arrayIds)
    {
        $arrayIds              = explode(',', $arrayIds);
        $deleteMessage         = Message::deleteDraftMessage($arrayIds);
        $deleteMessageReceiver = MessageReceiver::deleteDraftMessage($arrayIds);
        return redirect('/messages/drafts')->with('successMessage', 'Message deleted successfully.');
    }

    /**
     * Delete message from inbox
     *
     * @name   moveToTrashMessageFromInbox
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $arrayIds message id's
     *
     * @return void
     */
    public function moveToTrashMessageFromInbox($arrayIds)
    {
        $userId                = Auth::user()->id;
        $arrayIds              = explode(',', $arrayIds);
        $deleteMessageReceiver = MessageReceiver::trashMessage($arrayIds, $userId);
        return redirect('/messages/inbox')->with('successMessage', 'Message deleted successfully.');
    }

    /**
     * Delete message from sent
     *
     * @name   moveToTrashMessageFromSent
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Array $arrayIds message id's
     *
     * @return void
     */
    public function moveToTrashMessageFromSent($arrayIds)
    {
        $userId        = Auth::user()->id;
        $arrayIds      = explode(',', $arrayIds);
        $deleteMessage = Message::trashMessage($arrayIds, $userId);
        return redirect('/messages/sent')->with('successMessage', 'Message deleted successfully.');
    }

    /**
     * Opening message
     *
     * @name   showMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId  message id
     * @param String  $folderName folder name
     *
     * @return void
     */
    public function showMessage($messageId, $folderName)
    {
        $userId      = Auth::user()->id;
        $inboxCount  = MessageReceiver::inboxCount($userId);
        $draftCount  = Message::draftCount($userId);
        $receiversId = MessageReceiver::getReceiversIds($messageId);
        if ($folderName == 'inbox') {
            MessageReceiver::readMessageStatus($messageId, $userId);
        }
        $senderId       = Message::getSenderIds($messageId);
        $messageDetails = Message::messageDetails($messageId);
        return view('ms::show')
                        ->with('folderName', 'Trash')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('receiversId', $receiversId)
                        ->with('senderId', $senderId)
                        ->with('folderName', $folderName)
                        ->with('messageDetails', $messageDetails[0]);
    }

    /**
     * Opening trash messages
     *
     * @name   showTrashMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId  message id
     * @param String  $folderName folder name
     *
     * @return void
     */
    public function showTrashMessage($messageId, $folderName)
    {
        $userId      = Auth::user()->id;
        $inboxCount  = MessageReceiver::inboxCount($userId);
        $draftCount  = Message::draftCount($userId);
        $receiversId = MessageReceiver::getReceiversIds($messageId);
        if ($folderName == 'inbox') {
            MessageReceiver::readMessageStatus($messageId, $userId);
        }
        $senderId       = Message::getSenderIds($messageId);
        $messageDetails = Message::messageDetails($messageId);
        return view('ms::show_trash')
                        ->with('folderName', 'Trash')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('receiversId', $receiversId)
                        ->with('senderId', $senderId)
                        ->with('folderName', $folderName)
                        ->with('messageDetails', $messageDetails[0]);
    }

    /**
     * Opening draft message
     *
     * @name   showDraftMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId  message id
     * @param String  $folderName folder name
     *
     * @return void
     */
    public function showDraftMessage($messageId, $folderName)
    {
        $userId      = Auth::user()->id;
        $inboxCount  = MessageReceiver::inboxCount($userId);
        $draftCount  = Message::draftCount($userId);
        $receiversId = MessageReceiver::getReceiversIds($messageId);
        if ($folderName == 'inbox') {
            MessageReceiver::readMessageStatus($messageId, $userId);
        }
        $senderId       = Message::getSenderIds($messageId);
        $messageDetails = Message::messageDetails($messageId);
        return view('ms::showdraft')
                        ->with('folderName', 'Trash')
                        ->with('inboxCount', $inboxCount)
                        ->with('draftCount', $draftCount)
                        ->with('receiversId', $receiversId)
                        ->with('senderId', $senderId)
                        ->with('folderName', $folderName)
                        ->with('messageDetails', $messageDetails[0]);
    }

    /**
     * Sending draft message
     *
     * @name   sentDraftMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     *
     * @return void
     */
    public function sentDraftMessage($messageId)
    {
        $sentMessage         = Message::sentDraftMessage($messageId);
        $receiveDraftMessage = MessageReceiver::sentDraftMessage($messageId);
        return redirect('/messages/drafts')->with('successMessage', 'Message sent successfully.');
    }

    /**
     * Reply on message
     *
     * @name   replyMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Request $request    request data
     * @param Integer $messageId  message id
     * @param String  $folderName folder name
     *
     * @return void
     */
    public function replyMessage(Request $request, $messageId, $folderName)
    {
        $receiversId    = MessageReceiver::getReceiversIds($messageId);
        $senderId       = Message::getSenderIds($messageId);
        $messageDetails = Message::messageDetails($messageId);
        return view('ms::reply')
                        ->with('messageDetails', $messageDetails[0])
                        ->with('receiversId', $receiversId)
                        ->with('folderName', $folderName);
    }

    /**
     * Forward message
     *
     * @name   forwardMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId  message id
     * @param String  $folderName folder name
     *
     * @return void
     */
    public function forwardMessage($messageId, $folderName)
    {
        $usersList      = User::getUserList();
        $receiversId    = MessageReceiver::getReceiversIds($messageId);
        $senderId       = Message::getSenderIds($messageId);
        $messageDetails = Message::messageDetails($messageId);
        return view('ms::forward')
                        ->with('messageDetails', $messageDetails[0])
                        ->with('usersList', $usersList)
                        ->with('folderName', $folderName);
    }

    /**
     * Function to restore deleted message
     *
     * @name   restoreMessage
     * @access public
     * @author Vivek Bansal <vivek.bansal@silicus.com>
     *
     * @param Integer $messageId message id
     *
     * @return void
     */
    public function restoreMessage($messageId)
    {
        $userId = Auth::user()->id;
        Message::restoreMessage($messageId, $userId);
        MessageReceiver::restoreMessage($messageId, $userId);
        return redirect('/messages/trash')->with('successMessage', 'Message restore successfully.');
    }

}
