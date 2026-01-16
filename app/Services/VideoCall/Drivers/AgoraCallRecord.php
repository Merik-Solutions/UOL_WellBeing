<?php

namespace App\Services\VideoCall\Drivers;

use App\Services\VideoCall\Interfaces\VideoCallRecording;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Log;
use stdClass;

class AgoraCallRecord implements VideoCallRecording
{
    protected $appId = null;
    protected $url = null;
    protected $customerID = null;
    protected $customerSecret = null;

     public function __construct()
     {
        $this->appId = config('app.appId');
        $this->customerID = config('app.CustomerID');
        $this->customerSecret = config('app.CustomerSecret');
        $this->url = "https://api.agora.io/v1/apps/{$this->appId}/cloud_recording";
     }

    public function recordAcquire($data)
    {      
        $url = "{$this->url}/acquire";
        // Make Post Fields Array
        // $post_data = new stdClass();
        // $post_data->clientRequest = new stdClass();
        $post_data =[
            'cname' => strval($data['reservation_id']),
            'uid' => $data['u_id'],
            'clientRequest' => new stdClass()
        ];

        return $this->makePostCurlRequest($post_data,$url);
    }

    public function recordStart($data)
    {  
        $StorageVendor = config('app.storageVendor');
        $StorageRegion = config('app.storageRegion');
        $Bucket = config('app.bucket');
        $AccessKey = config('app.accessKey');
        $SecretKey = config('app.secretKey');
        
        $url = "{$this->url}/resourceid/{$data->resource_id}/mode/mix/start";
        
        $post_data = [            
            "cname"=> strval($data->reservation_id),
            "uid"=> $data->u_id,
            "clientRequest"=> [
                "token"=>  $data->signature,
                "recordingConfig"=> [
                    "channelType"=> 0,
                    "streamTypes"=> 2,
                    "audioProfile"=> 0,
                    "videoStreamType"=> 1,
                    "maxIdleTime"=> 15,
                    "transcodingConfig"=> [
                        "width"=> 360,
                        "height"=> 640,
                        "fps"=> 30,
                        "bitrate"=> 500,
                        "backgroundColor"=> "#FF0000"
                    ]
                ],
                "recordingFileConfig"=> [
                    "avFileType"=> [
                        "hls",
                        "mp4"
                    ]
                ],
                "storageConfig"=> [
                    "vendor"=> 1,
                    "region"=> 8,
                    "bucket"=> $Bucket,
                    "accessKey"=> $AccessKey,
                    "secretKey"=> $SecretKey,
                    "fileNamePrefix"=> [
                        strval($data->reservation_id)
                    ]
                ]
            ],

        ];
        return $this->makePostCurlRequest($post_data,$url);
    }

    public function callQuery($data)
    {
        $sid = $data->s_id ?? '';
        $url = "{$this->url}/resourceid/{$data->resource_id}/sid/{$sid}/mode/mix/query";  
        return $this->makeGetCurlRequest($url);
    }

    public function recordStop($data)
    {
        $url = "{$this->url}/resourceid/{$data->resource_id}/sid/{$data->s_id}/mode/mix/stop";

        $post_data =[
            'uid' => $data->u_id,
            'cname' => strval($data->reservation_id),
            'clientRequest' => new stdClass()
        ];

        return $this->makePostCurlRequest($post_data,$url);
    }

    public function makePostCurlRequest($data,$url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Authorization: Basic '.base64_encode($this->customerID.':'.$this->customerSecret)
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ['status'=> false, 'message' => "cURL Error #:" . $err];
        }
        $res = json_decode($response);
     
        if(isset($res->code)){
            return ['status' => false, 'message' => $res->reason, 'code' => $res->code];
        }
        return ['status' => true, 'data' => $res];
    }

    public function makeGetCurlRequest($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode($this->customerID.':'.$this->customerSecret),
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ['status'=>false, 'message' => "cURL Error #:" . $err];
        }
        return ['status' => true, 'data' => json_decode($response)];
    }

    public function getCallRecord($r_id,$sid=null){
        $url = "{$this->url}/resourceid/{$r_id}/sid/{$sid}/mode/mix/query"; 
        // Log::info($url);
        $this->makeGetCurlRequest($url);

    }
}
