<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;

class MyFatoorah extends PaymentMyfatoorahApiV2 implements HasRefund
{
    public function refund(
        $paymentId,$amount,$currencyCode=null,$reason=null,$orderId=null,$keyType='InvoiceId',
    ) {
        $rate = $this->getCurrencyRate($currencyCode);        
        $url = "$this->apiURL/v2/MakeRefund";
        $postFields = [
            "KeyType" => $keyType,
            "Key" => $paymentId,
            "Amount" => $amount / $rate,
            "Comment" => $reason,
        ];
        
        return $this->callAPI($url, $postFields, $orderId, 'Make Refund');
    }

    public function MakeRefund(Transaction $transaction)
    {
        $type = Arr::get($transaction->gateway_data, 'type');
        if ($type == 'online') {
            $data = Arr::get($transaction->gateway_data, 'data');
            $payment_id = Arr::get($data, 'PaymentId');
            $this->refund(
                $payment_id,
                $transaction->amount,
                config('myfatoorah.country_iso'),
                'Reservation Canceled',
                $transaction->id,
                "InvoiceId",
                false,
                false,
                0,
            );
        }
        throw ValidationException::withMessages([
            'transaction_id' => 'Gateway is not myfatoorah ',
            'reservation_id' => 'Gateway is not myfatoorah ',
        ]);
    }
}
