<?php

/**
 * SendSms class to send Sms to intended phones
 *
 * @name     SendSms.php
 * @category SendSms
 * @package  SendSms
 * @author   Tanmoy Chakraborty <tanmoy.chakraborty@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link     None
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Reminder\Models\CustomSms;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Config;

/**
 * SendSms class to send Sms to intended phones
 *
 * @name     SendSms.php
 * @category SendSms
 * @package  SendSms
 * @author   Tanmoy Chakraborty <tanmoy.chakraborty@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link     None
 */
class SendSms extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script will send sms to the users phone';

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
        $arrIds      = [];
        $smsObj      = [];
        $phoneNo     = 'phone_no';
        $smsContent  = 'sms_content';
        $userId      = 'user_id';
        $deviceToken = 'device_token';

        $smsData = CustomSms::getSmsInfo();
        foreach ($smsData as $data) {
            $targetPhoneNo                    = "";
            $target                           = array ("@@@UserName@@@", "@@@SupportEmail@@@", "@@@PhoneNo@@@");
            $source                           = array ($data->name, $data->email, $data->$phoneNo);
            $getSmsContent                    = str_replace($target, $source, $data->$smsContent);
            $targetPhoneNo                    = $data->$phoneNo;
            $arrIds[]                         = $data->id;
            $smsObj[$data->id]['phonoNo']     = $data->$phoneNo;
            $smsObj[$data->id]['deviceToken'] = $data->$deviceToken;
            $smsObj[$data->id]['content']     = $getSmsContent;
            $smsObj[$data->id]['id']          = $data->id;
        }

        //sendind
        $sendConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $sendChannel    = $sendConnection->channel();
        $sendChannel->queue_declare('sms', false, false, false, false);

        $msg = new AMQPMessage(serialize($smsObj));
        $sendChannel->basic_publish($msg, '', 'sms');
        $sendChannel->close();
        $sendConnection->close();

        //receiving
        $receiveConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $receiveChannel    = $receiveConnection->channel();
        $receiveChannel->queue_declare('sms', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback          = function ($receiveMsg) {

            $smsInfo = unserialize($receiveMsg->body);
            ///////////////Followed the link https://semysms.net/api.php?locale=en///////////////////
            $url     = Config::get('reminder.SMS_URL'); //Url address for sending SMS
            $token   = Config::get('reminder.SMS_TOKEN');  //  Your token (secret)
            foreach ($smsInfo as $phone) {
                $data   = array (
                    "phone"  => $phone['phonoNo'],
                    "msg"    => $phone['content'],
                    "device" => $phone['deviceToken'],
                    "token"  => $token
                );
                $curl   = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                $output = curl_exec($curl);
                if (false != $output) {
                    $arrIds[] = $phone['id'];
                }
                curl_close($curl);
                echo $output;
            }
            CustomSms::updateSmsSentStatus($arrIds);
        };
        $receiveChannel->basic_consume('sms', '', false, true, false, false, $callback);
        while (count($receiveChannel->callbacks)) {
            $receiveChannel->wait();
        }
    }

}
