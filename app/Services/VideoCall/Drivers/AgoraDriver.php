<?php

namespace App\Services\VideoCall\Drivers;

use App\Services\VideoCall\Drivers\Agora\RtcTokenBuilder;
use App\Services\VideoCall\Interfaces\SignatureContract;
use DateTime;
use DateTimeZone;

class AgoraDriver implements SignatureContract
{
    public function generateSignature($channelName,$role_id)
    {
        $appID = config('services.agora.app_id');
        $appCertificate = config('services.agora.app_secret');

        $uid = null;
        // role id dr =1;
        // role id patient,agora call recorder = 0 
        if($role_id == 'doctor'){
            $role = RtcTokenBuilder::RolePublisher;
        }else{
            $role = RtcTokenBuilder::RoleAttendee;
        }
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime(
            'now',
            new DateTimeZone('UTC'),
        ))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        return RtcTokenBuilder::buildTokenWithUid(
            $appID,
            $appCertificate,
            (string) $channelName,
            $uid,
            $role,
            $privilegeExpiredTs,
        );
    }
}
