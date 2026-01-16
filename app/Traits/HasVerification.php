<?php

namespace App\Traits;

use App\Models\VerficationCode;
use App\Notifications\SendVerificationCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Config;
trait HasVerification
{

    private $phone;
    public function sendCode($phone)
    {
        try {
            $verification = $this->verficationCodes()->create([
                'code' => randNumber(),                
            ]);

            $this->phone=substr($phone['phone'],1);

            // $this->notify(
            //     new SendVerificationCode(
            //         "Your Verification Code is $verification->code",
            //     ),
            // );

            $appsid =Config('unifonic.appsid');
            $sender =Config('unifonic.sender');

            $resp= Http::post("https://el.cloud.unifonic.com/wrapper/sendSMS.php?appsid={$appsid}&msg=Your OTP is {$verification['code']}&to={$this->phone}&sender={$sender}&baseEncode=false&encoding=UCS2");
            return $resp;
        } catch (\Exception $e) {
            Log::info('Send message Failed');
        }
    }
    public function verficationCodes(): MorphMany
    {
        return $this->morphMany(VerficationCode::class, 'verifiable');
    }

    public function getVerificationCodeAttribute()
    {
        return optional(
            $this->verficationCodes()
                ->isValid()
                ->latest()
                ->first(['code']),
        )->code;
    }
}
