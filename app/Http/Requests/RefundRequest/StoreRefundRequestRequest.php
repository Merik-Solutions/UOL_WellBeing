<?php

namespace App\Http\Requests\RefundRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRefundRequestRequest extends FormRequest
{

    public function rules()
    {
        return [
            'transaction_id' => ['required', 'integer', 'exists:transactions,id'],

        ];
    }
}
