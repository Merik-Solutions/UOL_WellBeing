<?php

namespace App\Channels;

use App\Models\Device;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CustomFCMChannel
{
    /**
     * Send the given notification.
     *
     * @param User|Doctor $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send(Doctor|User $notifiable, Notification $notification): void
    {
        $tokens = $notifiable->fcm_token->pluck('token');
        $responses = [];

        foreach ($tokens as $item) {
            $deviceData = Device::where('token', $item)->first();

            if ($deviceData && $deviceData->platform == 'ios' && $notification->toDatabase($notifiable)['title_en'] == 'Call Started') {
                $responses[] = $this->sendIOSCurl($deviceData->voip, $notification, $notifiable);
            } else {
                $responses[] = $this->sendAndroidCurl($item, $notification, $notifiable);
            }
        }

        Log::info('fcm response', $responses);
    }


    private function sendAndroidCurl($token, $notification, $notifiable)
    {
        $curl = curl_init();
        //$key = config('firebase.key');
        $key = getFCMToken();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/kindahealth-102c7/messages:send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' =>  $notification->toDatabase($notifiable)['title'],
                        'body' =>  $notification->toDatabase($notifiable)['body'],
                    ],
                    'data'   => [
                        'notification_id' => $notification->toDatabase($notifiable)['notification_id'],
                        'unread_messages' => strval($notification->toDatabase($notifiable)['unread_messages']),
                        'type' => $notification->toDatabase($notifiable)['type'],
                        'id' => strval($notification->toDatabase($notifiable)['id']),
                        'title' => $notification->toDatabase($notifiable)['title'],
                        'title_ar' => $notification->toDatabase($notifiable)['title_ar'],
                        'title_en' => $notification->toDatabase($notifiable)['title_en'],
                        'date' => $notification->toDatabase($notifiable)['date'],
                        'message' => $notification->toDatabase($notifiable)['message'],
                        'body' => $notification->toDatabase($notifiable)['body'],
                    ]
                ]

            ]),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $key",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function sendIOSCurl($token, $notification, $notifiable)
    {
        $alldata =
            json_encode(
                array(
                    "aps" =>
                    array(
                        "alert" =>
                        array(
                            "uuid" => $notification->toDatabase($notifiable)['notification_id'],
                            "incoming_caller_id" => $notification->toDatabase($notifiable)['notification_id'],
                            "incoming_caller_name" => "Kinda"
                        )
                    )
                )
            );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.push.apple.com/3/device/' . $token,
            // CURLOPT_URL => 'https://api.push.apple.com/3/device/141bfd9faf9b434a06483bb87b8f9238c2393eb84c76a3bf99cea8a011572390',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_2_0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_SSLCERT =>  storage_path('KindaHealthVOIP.pem'),
            CURLOPT_SSLCERT => 'KindaHealthVOIP.pem',
            CURLOPT_SSLCERTPASSWD => 'KindaHealthVoip54321',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POSTFIELDS => '{
                    "aps": {
                        "alert": {
                            "uuid": "' . $notification->toDatabase($notifiable)['notification_id'] . '",
                            "incoming_caller_id": "' . $notification->toDatabase($notifiable)['id'] . '",
                            "incoming_caller_name": "Kinda"
                        }
                    }
                }',
            CURLOPT_HTTPHEADER => array(
                'apns-push-type: voip',
                'apns-expiration: 0',
                'apns-priority: 10',
                'apns-topic: com.kindahealth.patientapp.voip'
            ),
        ));


        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            return response()->json(['success' => false, 'response' => $alldata], 200);
        }
        curl_close($curl);
        //Log::info('fcm response to IOS', $response);
        return response()->json(['success' => true, 'response' => $response], 200);
    }
}
