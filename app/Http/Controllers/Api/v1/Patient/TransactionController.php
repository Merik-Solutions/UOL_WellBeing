<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()
            ->user()
            ->transactions()
            ->with('sender')
            ->get();
        return responseJson(TransactionResource::collection($transactions));
    }

    public function addToWallet(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'gateway' => ['required', 'string', 'in:online'],
        ]);
        $transaction = auth()
            ->user()
            ->addToWallet($request->amount, $request->gateway);

        return responseJson(
            ['transaction_id' => $transaction->id,
                'amount' => $transaction->total,
                'description' => $transaction->description,
                'transaction_secret' => $transaction->client_secret,
                'gateway' => $transaction->gateway,
            ],
            __('Added Successfully'),
        );
    }
}
