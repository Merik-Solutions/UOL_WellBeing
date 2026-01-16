<?php

namespace App\Http\Resources\Transaction;

use App\Enums\MyFatoorah\TransactionStatus;
use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Money\Currency;

/**
 * @mixin  Transaction;
 */
class TransactionResource extends JsonResource
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
            'billable' => $this->billable?->getTable() ?? 'wallet',
            'type' => $this->type(),
            'billable_data' => $this->billable,
            'can_refund' => $this->CanRefund(),
            'gateway' => $this->gateway,
            'total' => number_format($this->total, 1),
            'currency' => $this->currency,
            'transaction_status' => $this->status(),
            'is_refunded' => $this->status(),
            'payment_status' => $this->resource->status,
            'description' => $this->description,
            'date' => $this->created_at->format('Y-m-d h:i a'),
            'wallet' => number_format(auth()->user()->wallet, 1),
            'previous_amount' => $this->previous_amount,
        ];
    }

    public function type(): string
    {
        if (
            $this->sender_id == auth()->id() &&
            $this->sender->phone == auth()->user()->phone
        ) {
            return __('Out');
        }
        return __('In');
    }

    public function status(): string
    {
        if ($this->gateway != 'wallet' && $this->gateway_id == null) {
            return 'Not Accepted';
        }
        return 'Accepted';
    }

    /**
     * @return bool
     */
    public function CanRefund(): bool
    {
        if ($this->status != TransactionStatus::SUCCESS()->value) {
            return false;
        }

        if ($this->refund_id != null || $this->refund_request != null) {
            return false;
        }

        if ($this->billable_type != null && Str::contains('package', $this->billable_type)) {
            return true;
        }

        if ($this->billable_type != null && Str::contains('reservation', $this->billable_type) && $this->billable?->status == 'finished') {
            return true;
        }
        return false;
    }
}
