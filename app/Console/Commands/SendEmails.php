<?php

/**
 * SendEmails class to send emails to intended emails
 *
 * @name     SendEmails.php
 * @category SendEmails
 * @package  SendEmails
 * @author   Tanmoy Chakraborty <tanmoy.chakraborty@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link     None
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Reminder\Models\Emails;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * SendEmails class to send emails to intended emails
 *
 * @name     SendEmails.php
 * @category SendEmails
 * @package  SendEmails
 * @author   Tanmoy Chakraborty <tanmoy.chakraborty@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link     None
 */
class SendEmails extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script will send emails to the users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $arrIds    = [];
        $emailObj  = [];
        $emailData = Emails::getEmailInfo();
        foreach ($emailData as $data) {
            $emailObj[$data->id]['email']        = $data->email;
            $emailObj[$data->id]['subject']      = $data->subject;
            $emailObj[$data->id]['userName']     = $data->userName;
            $emailObj[$data->id]['templateName'] = $data->templateName;
            $emailObj[$data->id]['phoneNo']      = (isset($data->phoneNo) && $data->phoneNo != "") ? $data->phoneNo : '';
            $emailObj[$data->id]['id']           = $data->id;
        }

        //sendind
        $sendConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $sendChannel    = $sendConnection->channel();
        $sendChannel->queue_declare('email', false, false, false, false);

        $emailMsg = new AMQPMessage(serialize($emailObj));
        $sendChannel->basic_publish($emailMsg, '', 'email');
        $sendChannel->close();
        $sendConnection->close();

        //receiving
        $receiveConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $receiveChannel    = $receiveConnection->channel();
        $receiveChannel->queue_declare('email', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback          = function ($receiveMsg) {
            $emailInfo = unserialize($receiveMsg->body);
            foreach ($emailInfo as $eml) {
                $subject = $eml['subject'];
                $toEmail = $eml['email'];

                Mail::queue('reminder::emails.' . $eml['templateName'], array ('UserName' => $eml['userName'], 'SupportEmail' => $toEmail, 'PhoneNo' => $eml['phoneNo']), function ($message) use ($toEmail, $subject) {
                    $message->to($toEmail)->subject($subject);
                });

                $arrIds[] = $eml['id'];
            }
            Emails::updateSentStatus($arrIds);
        };
        $receiveChannel->basic_consume('email', '', false, true, false, false, $callback);
        while (count($receiveChannel->callbacks)) {
            $receiveChannel->wait();
        }
    }

}
