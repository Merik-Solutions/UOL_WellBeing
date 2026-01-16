<?php

use App\Helpers\Responder;
use App\Models\UserDoctorCallLog;
use App\Services\FCM\AndroidConfig;
use App\Services\FCM\AndroidFcmOptions;
use App\Services\FCM\ApnsConfig;
use App\Services\FCM\ApnsFcmOptions;
use App\Services\FCM\FcmOptions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidMessagePriority;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use Carbon\Carbon;

use NotificationChannels\Fcm\Resources\WebpushConfig;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

/**
 * @param int $status
 * @param string|null $msg
 * @param iterable|object|null $data
 * @return \Illuminate\Http\JsonResponse
 */

function permissionCheck($role)
{
    return in_array(
        $role,
        request()
            ->user()
            ->getAllPermissions()
            ->pluck('name')
            ->toArray()
    );
}

if (! function_exists('userDoctorCallLog')) {
    function userDoctorCallLog($initiator,$initiator_id,$res_id,$status){
        UserDoctorCallLog::create([
            'reservation_id' =>$res_id,
            'initiator' =>$initiator,
            'initiator_id' =>$initiator_id,
            'status' =>$status,
        ]);
    }
}

if (! function_exists('penalizeDoctor')) {
    function penalizeDoctor($percent,$price){
        $commission = env('APP_COMMISSION' ,20)/100 * $price;
        $price = $price - $commission;
        $penalty = $percent / 100 * $price;
        return $price - $penalty;
    }
}

if (! function_exists('assets')) {
     // assets path for cpanle server
    function assets($path, $secure = null)
    {
        if(config('app.is_server')){
           $path =  config('app.absolute_path')."/".$path;
        }
        return app('url')->asset($path, $secure);
    }
    
}


function appCommission($reservationTotal,$packagesTotal = 0){
    $total = $reservationTotal + $packagesTotal;
    $commission = env('APP_COMMISSION' ,20)/100;
    $totalComm = $commission * $total;
    $totalPayable = $total - $totalComm;
    return ['commission' => $totalComm, 'payable' => $totalPayable];
}

function addAppCommission($price){
    $commission = config('app.commission' ,20)/100;
    $totalComm = $commission * $price;
    $total = $price + $totalComm;
    return $total;
}

function calculateAppCommission($price){
    $app_rate = config('app.commission' ,20)/120;
    $commission = $app_rate * $price;
    return (float)$commission;
}

function calculateVATtax($national_id, $price){
    $isSaudi = $national_id[0] ?? null;
    if($isSaudi == 1){
        return 0.00;
    }else{
        $vat = config('app.vat_tax')/100;
        $vat_of_total = $vat * $price;
        return $vat_of_total;
    }
}

function priceWithVATtax($price){    
        $vat = config('app.vat_tax')/100;
        $vat_of_total = $vat * $price;
        return $vat_of_total;
}

function calculateDiscount($discount, $price){    
    $dis = $discount/100;
    $dis_of_total = $dis * $price;        
    return $dis_of_total;
}

function findDiscountedAmount($discount, $price){
    $service_rate = addAppCommission($price);    
    $dis = $discount/100;
    $dis_of_total = $dis * $service_rate;        
    return$dis_of_total;
}

function getPriceVatTax($national_id, $price){    
    $isSaudi = $national_id[0] ?? null;
    $vat = 0.00;    
    if($isSaudi == 1){
        return 0.00;
    }else{
        $vat = config('app.vat_tax') /115;        
        return  $vat * $price;
    }
}

function splitPriceVatAndCommission($national_id, $price){
    $isSaudi = $national_id[0] ?? null;    
    if($isSaudi == 1){
        $commission = (config('app.commission') * $price) /120;
        $service_price = $price - $commission;
        $vat = 0.00;
        return ['price'=> $service_price, 'commission' => $commission, 'vat' => $vat];
    }else{
        $vat = (config('app.vat_tax') * $price) /115;
        $price_before_vat = $price - $vat;
        $commission = (config('app.commission') * $price_before_vat) /120;
        $service_price = $price_before_vat - $commission;
        return ['price'=> $service_price, 'commission' => $commission, 'vat' => $vat];
    }

}

function disputedReservationNotify(){
    // 
}

function userData()
{
    return auth()->user();
}

function responseJson(
    $data = null,
    ?string $msg = null,
    int $status = 200,
    $errors = null
) {
    return new Responder($data, $msg, $status, $errors);
}

function days()
{
    return [
        0 => __('Sun'),
        1 => __('Mon'),
        2 => __('Tue'),
        3 => __('Wen'),
        4 => __('Thr'),
        5 => __('Fri'),
        6 => __('Sat'),
    ];
}

function setActive($routeName, $active = 'active')
{
    return request()->routeIs($routeName) ? $active : null;
}

function fileUrl($image)
{
    if ($image == null) {
        return null;
    }

    if (strpos($image, 'http://') == false) {
        if(config('app.is_server')){
            $substringToFind = "/kindahealth/public"; 
            if(strpos($image, $substringToFind) !== false) 
            {
                $image = $image;
            } else {  
                $image = assets($image);
            } 
        }else {  
            $image = assets($image);
        }  
    }
    return $image;
}

/**
 * generate random number
 * @param int $digits
 * @return int
 */
function randNumber(int $digits = 4): int
{
    return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}

function saveFile(UploadedFile $file, $path): string
{
    $sys_path = config('app.is_server')? '/'.config('app.absolute_path'): '';
    return "{$sys_path}/storage/" . $file->store($path);
}

function avatar(): string
{
    $sys_path = config('app.is_server')? '/'.config('app.absolute_path'): '';
    return "{$sys_path}/dashboard/avatar.png";
}

function setAndroidConfig()
{
    //    AndroidConfig::create()->
    return AndroidConfig::create()
        ->setPriority(AndroidMessagePriority::HIGH())
        ->setFcmOptions(
            AndroidFcmOptions::create()
                ->setContentAvailable(true)
                ->setAnalyticsLabel('analytics'),
        )
        ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'));
}

function setApnsConfig()
{
    return ApnsConfig::create()->setFcmOptions(
        ApnsFcmOptions::create()
            ->setContentAvailable(true)
            ->setAnalyticsLabel('analytics_ios'),
    );
}

function firebaseInit(array $data, string $title, string $message): FcmMessage
{
    return FcmMessage::create()
        ->setData(array_map('strval', $data))
        ->setFcmOptions(FcmOptions::create()->setContentAvailable(true))
        ->setNotification(
            \NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($title)
                ->setBody($message),
        )
        ->setAndroid(setAndroidConfig())
        ->setApns(setApnsConfig());
}

function getClassName($class): ?string
{
    $path = explode('\\', get_class($class));
    return array_pop($path);
}

 function getFCMToken(){
   
    $credentialsFilePath = storage_path('/app/kindahealth-102c7-40df6dcb4917.json'); //replace this with your actual path and file name
    $client = new \Google_Client();
    $client->setAuthConfig($credentialsFilePath);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    $client->refreshTokenWithAssertion();
    $token = $client->getAccessToken();
    return $token['access_token'];
}


function hasPermission($permission){

    return auth()->user()->roles[0]->hasPermissionTo($permission);

}

function timeDiffInHours($firstTime, $lastTime): string
{
    $firstTime = strtotime($firstTime);
    $lastTime = strtotime($lastTime);
	$difference = abs($firstTime - $lastTime)/3600;
	return $difference;
}

if (! function_exists('showCallRecording')) {
    function showCallRecording($file_path){
        if($file_path){
            return Storage::disk('s3')->temporaryUrl($file_path, Carbon::now()->addMinutes(60));       
        }else{
            return '';
        }
    }
}