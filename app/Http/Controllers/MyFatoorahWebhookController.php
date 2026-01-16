<?php

namespace App\Http\Controllers;

use App\Enums\MyFatoorah\RefundStatus;
use App\Enums\MyFatoorah\TransactionStatus;
use App\Enums\MyFatoorah\WebHookEventType;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MyFatoorahWebhookController extends Controller
{

    public function __invoke(Request $request)
    {
//        try {
        Log::channel('webhook')->info('comming webhook from myfatoorah');
        Log::channel('webhook')->info(json_encode($request->all()));
        Log::channel('webhook')->info('============================');
        $eventType = WebHookEventType::tryFrom($request->input('EventType'));
        $data = $request->input('Data');
        if (WebHookEventType::TransactionsStatusChanged()->equals($eventType)) {
            Log::channel('webhook')->info('transaction is checkout');
            Log::channel('webhook')->info(json_encode($request->all()));
            Log::channel('webhook')->info('status is ========>' . TransactionStatus::tryFrom($data['TransactionStatus'])->label);
            Log::channel('webhook')
                ->info('transaction id  is==========>' . $data['CustomerReference']);
            $transaction = Transaction::find($data['CustomerReference']);
            $transaction->fill([
                'status' => TransactionStatus::tryFrom($data['TransactionStatus'])->label,
                'gateway_id' => $data['InvoiceId'],
                'gateway_data' => [
                    'type' => 'myfatoorah',
                    'data' => $request->all(),
                ],
            ])->save();

        }

        if (WebHookEventType::RefundStatusChanged()->equals($eventType)) {
            Log::channel('webhook')->info('transaction is refund');

            $transaction = Transaction::find($data['RefundReference']);
            $transaction->fill([
                'status' => RefundStatus::tryFrom($data['RefundStatus'])->label,
                'refund_id' => $data['RefundId'],
                'gateway_data' => [
                    'type' => 'myfatoorah',
                    'data' => $request->all(),
                ],
            ])->save();

        }
//        } catch (ModelNotFoundException $exception) {
//            throw  $exception;
//            Log::channel('webhook',)->error($exception->getMessage(), $exception->getTrace());
//        }
        return response()->json(['status' => 'success']);
    }


}
