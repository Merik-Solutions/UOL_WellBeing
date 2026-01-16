<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Presciption\PrescriptionResource;
use App\Models\Reservation;
use App\Repositories\interfaces\ReservationRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/**
 * @mixin  Reservation
 */
class ReservationResource extends JsonResource
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
            'id' => $this->id,
            'date' => CarbonImmutable::parse($this->date)->toDateString(),
            'price' => round($this->price, 1),
            'status' => $this->status,
            'from_time' => CarbonImmutable::parse(
                $this->from_time,
            )->toTimeString(),
            'to_time' => CarbonImmutable::parse($this->to_time)->toTimeString(),
            'pending_request' => $this->getPendingRequest(),
            //relations
            'doctor' => $this->getDoctor(),
            'patient' => $this->getPatient(),
            'transaction_id' => $this->getOnlineTransactionId() /*$this->transactions?->pluck('id')->implode('-')*/,
            'transaction_online_status' => $this->getOnlineTransactionStatus() /*$this->transactions?->pluck('id')->implode('-')*/,
            'transaction_secret' => $this->getTransactionSecret(),
            'has_prescription' => (int) $this->prescription_count === 1,
            'has_rating' => (int) $this->rating_count > 0,
            'wallet' => $this->wallet,
            'online' => $this->online,
            'payment_id' => Arr::get(
                $this->getOnlineTransaction()?->gateway_data ?? [],
                'data.PaymentId',
            ),
            'transactions' => $this->transactions,
            'vat_tax' => $this->patient ? floatval(calculateVATtax($this->patient->national_id,$this->service_rate)):floatval(priceWithVATtax($this->service_rate)),
            'reservation_status' => $this->reservation_status,
        ];
    }

    public static function getStatus($status)
    {
        $status =
            app(ReservationRepository::class)->getConstantsFlipped('STATUS')[
                $status
            ] ?? $status;
        return __($status);
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

    public function getPendingRequest()
    {
        return $this->whenLoaded(
            'pending_request',
            fn() => [
                'id' => $this->pending_request->id,
                'status' => $this->pending_request->status,
                'date' => $this->pending_request->date,
                'from_time' => $this->pending_request->from_time,
                'to_time' => $this->pending_request->to_time,
            ],
            null,
        );
    }

    public function getDoctor()
    {
        return $this->whenLoaded(
            'doctor',
            function () {
                return [
                    'id' => (int) $this->doctor_id,
                    'name' => $this->doctor->name,
                    'title' => $this->doctor->title,
                    'period' => $this->doctor->period,
                    'category' => $this->doctor?->category?->name,
                    'img' => fileUrl($this->doctor->image),
                    'price' => floatval(addAppCommission($this->doctor->price)),
                ];
            },
            null,
        );
    }

    public function getPatient()
    {
        return $this->whenLoaded('patient', function () {
            return [
                'id' => (int) $this->patient_id,
                'user_id' => $this->user_id,
                'name' => $this->patient->name,
                'birthdate' => $this->patient->birthdate,
                'age' => $this->patient->age,
                'img' => fileUrl($this->patient->image),
                'code' => $this->patient->medical_history,
            ];
        });
    }
}
