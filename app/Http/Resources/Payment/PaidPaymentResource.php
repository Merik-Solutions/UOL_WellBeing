<?php

namespace App\Http\Resources\Payment;

use App\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PaidPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return dd($this);

        $res_key = 'reservation_total'; 
        $upd_key = 'udp_total'; 
        $res  = array_map(function ($item) use ($res_key)  {
            if(isset($item[$res_key])){
                $commission = env('APP_COMMISSION',20)/100 * $item[$res_key];
                $item[$res_key] = $item[$res_key] - $commission;
            }
            return $item;
        },$this->paidReservations->toArray());
        $udp  = array_map(function ($item) use ($upd_key)  {
            if(isset($item[$upd_key])){
                $commission = env('APP_COMMISSION',20)/100 * $item[$upd_key];
                $item[$upd_key] = $item[$upd_key] - $commission;
            }
            return $item;
        },$this->paidPackages->toArray());

        return [
            "id" => $this->id,
            "name_en" => $this->name_en ?? 'Kinda',
            "name_ar" => $this->name_ar ?? 'Kinda',           
            "paidReservations" =>  $res,            
            "paidPackages" => $udp,
        ];

    }
}
