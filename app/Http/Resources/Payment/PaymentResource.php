<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $res_price = 'price'; 
        $upd_price = 'price'; 
        $res  = array_map(function ($item) use ($res_price)  {
            if(isset($item[$res_price])){
                $commission = env('APP_COMMISSION' ,20)/100 * $item[$res_price];
                $item[$res_price] = $item[$res_price] - $commission;
            }
            return $item;
        },$this->reservation->toArray());
        $udp  = array_map(function ($item) use ($upd_price)  {
            if(isset($item[$upd_price])){
                $commission = env('APP_COMMISSION' ,20)/100 * $item[$upd_price];
                $item[$upd_price] = $item[$upd_price] - $commission;
            }
            return $item;
        },$this->userDoctorPackage->toArray());
        return [
            "name_en" => $this->name_en ?? 'Kinda',
            "name_ar" => $this->name_ar ?? 'Kinda',           
            "reservation" =>  $res ?? null,
            "userDoctorPackage" =>  $udp ?? null,
        ];
    }
}
