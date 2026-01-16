<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class StripWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        if (
            in_array($request->type, [
                'checkout.session.async_payment_succeeded',
                'charge.succeeded',
                'checkout.session.completed',
                'order.payment_succeeded',
                'payment_intent.succeeded',
            ])
        ) {
            Transaction::query()
                ->whereJsonContains(
                    'gateway_session->gateway',
                    'stripe',
                )
                ->whereJsonContains(
                    'gateway_session->data->id',
                    $request->data['object']['id'],
                )
                ->update(['gateway_id' => $request->data['object']['id']]);
        }
        return responseJson(null, 'success');
    }
}
