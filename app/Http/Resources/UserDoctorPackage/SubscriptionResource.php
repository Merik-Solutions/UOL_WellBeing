<?php

namespace App\Http\Resources\UserDoctorPackage;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'doctor_id' => $this->doctor_id,
            'package_id' => $this->package_id,
            'doctor_package_id' => $this->doctor_package_id,
            'expired_at' => $this->expired_at,
            'price' => number_format($this->price, 1),
            'user_id' => $this->user_id,
            'promocode_id' => $this->promocode_id,
            'wallet' => $this->wallet,
            'online' => $this->online,
            'transaction_id' => $this->getOnlineTransactionId(),
            'transaction_status' => $this->getOnlineTransactionStatus(),
            'transaction_secret' => $this->getTransactionSecret(),
            'payment_id' => Arr::get(
                $this->getOnlineTransaction()?->gateway_data ?? [],
                'data.PaymentId',
            ),
            'transactions' => $this->transactions,
        ];
    }

    public function getTransactionSecret()
    {
        return $this->when(
            $this->resource->relationLoaded('transaction'),
            fn() => $this->transactions
                ?->where('gateway', '!=', 'wallet')
                ?->first()?->client_secret,
        );
    }

    public function getOnlineTransactionId()
    {
        return $this->getOnlineTransaction()?->id;
    }

    public function getOnlineTransactionStatus()
    {
        return $this->getOnlineTransaction()?->status;
    }

    public function getOnlineTransaction()
    {
        return $this->transactions?->where('gateway', '!=', 'wallet')?->first();
    }
}
