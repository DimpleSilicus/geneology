<?php

/**
 * SendNotifications class to send notifications to intended phones
 *
 * @name     SendNotifications.php
 * @category SendNotifications
 * @package  SendNotifications
 * @author   Tanmoy Chakraborty <tanmoy.chakraborty@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link     None
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Reminder\Models\PushNotifications;
use Illuminate\Support\Facades\Config;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * SendNotifications class to send notifications to intended phones
 *
 * @name     SendNotifications.php
 * @category SendNotifications
 * @package  SendNotifications
 * @author   Tanmoy Chakraborty <tanmoy.chakraborty@silicus.com>
 * @license  Silicus http://www.silicus.com/
 * @version  GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link     None
 */
class SendNotifications extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This script will send notification to the users';

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
        $pushObj                 = [];
        $arrIds                  = [];
        $theme                   = Config::get('app.theme');
        $phoneNo                 = "phone_no";
        $clientRegistrationId    = "client_registration_id";
        $pushNotificationContent = "push_notification_content";
        $pushNotifications       = PushNotifications::getPushNotificationInfo(); //get all push notification data from "push_notification" table

        foreach ($pushNotifications as $data) {
            $target                 = array ("@@@UserName@@@", "@@@SupportEmail@@@", "@@@PhoneNo@@@");
            $source                 = array ($data->name, $data->email, $data->$phoneNo);
            $getNotificationContent = str_replace($target, $source, $data->$pushNotificationContent);


            $pushObj[$data->id]['title']                = $data->title;
            $pushObj[$data->id]['message']              = $getNotificationContent;
            $pushObj[$data->id]['image']                = (isset($data->image) && $data['image'] != '') ? $data->image : '';
            $pushObj[$data->id]['clientRegistrationId'] = $data->$clientRegistrationId;
            $pushObj[$data->id]['id']                   = $data->id;
        }

        //sendind
        $sendConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $sendChannel    = $sendConnection->channel();
        $sendChannel->queue_declare('notification', false, false, false, false);

        $notificationMsg   = new AMQPMessage(serialize($pushObj));
        $sendChannel->basic_publish($notificationMsg, '', 'notification');
        $sendChannel->close();
        $sendConnection->close();
        //receiving
        $receiveConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $receiveChannel    = $receiveConnection->channel();
        $receiveChannel->queue_declare('notification', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback          = function ($receiveMsg) {
            $notificationInfo = unserialize($receiveMsg->body);
            foreach ($notificationInfo as $data) {
                $registrationIds = $data['clientRegistrationId'];
                $url             = Config::get('reminder.NOTIFICATION_API_URL');
                $formatMessage   = array (
                    'title'     => $data['title'],
                    'message'   => $data['message'],
                    'largeIcon' => (isset($data['image']) && $data['image'] != '') ? base_path() . "/public/theme/" . $theme . "/assets/reminder/upload/" . $data['image'] : '',
                    'vibrate'   => 1
                );

                $headers  = array (
                    'Authorization: key=' . Config::get('reminder.NOTIFICATION_API_ACCESS_KEY'),
                    'Content-Type: application/json'
                );
                $fields   = array (
                    'registration_ids' => $registrationIds,
                    'data'             => $formatMessage,
                );
                return $this->_useCurl($url, $headers, json_encode($fields));
                $arrIds[] = $data->id;
            }
            PushNotifications::updateNotificationSentStatus($arrIds);
        };
        $receiveChannel->basic_consume('notification', '', false, true, false, false, $callback);
        while (count($receiveChannel->callbacks)) {
            $receiveChannel->wait();
        }
    }

    /**
     * Description
     *
     * @name   _useCurl
     * @access private
     * @author Tanmoy Chakraborty <tanmoy05.chakraborty@silicus.com>
     *
     * @param String $url     url string
     * @param String $headers header string
     * @param Array  $fields  Fields string
     *
     * @return void
     */
    private function _useCurl($url, $headers, $fields = null)
    {
        // Open connection
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }
            // Execute post
            $result = curl_exec($ch);
            if ($result === false) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);

            return $result;
        }
    }

}
