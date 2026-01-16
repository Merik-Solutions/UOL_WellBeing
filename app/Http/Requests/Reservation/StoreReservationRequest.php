<?php

namespace App\Http\Requests\Reservation;

use App\Criteria\IsActiveCriteria;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\PromocodeRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor_id' => 'required|integer|exists:doctors,id',
            'schedule_id' => 'required|integer|exists:schedules,id',
            'date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'from_time' => ['required'],
            'patient_id' => ['required','integer','exists:patients,id'],
            'to_time' => ['required'],
            'promocode_id' => [
                'nullable',
                'integer',
                Rule::exists('promocodes', 'id'),
            ],
            'gateway' => ['sometimes', 'nullable', 'string', 'in:wallet,online,both,online,myfatoorah'],
            // 'wallet' => ['required', 'numeric',],
            'online' => ['required', 'numeric',],
            'invoice_id' => ['required'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['user_id'] = auth()->id();
        $data['patient_id'] = request('patient_id');
        $doctorRepo = app(DoctorRepository::class);
        $data['price'] = $this->calcPrice(
            addAppCommission($doctorRepo->PeriodPrice($this->doctor_id))
        );
        return $data;
    }

    public function calcPrice(float $price): float
    {
        if ($this->promocode_id) {
            /** @var \App\Models\Promocode $promocode */
            $promocode = app(PromocodeRepository::class)
                ->pushCriteria(IsActiveCriteria::class)
                ->ForReservation()
                ->where('id', $this->promocode_id)
                ->firstOrNew();
            $price = $promocode->PriceAfterDiscount($price);
        }
        return $price;
    }

    public function validatePaidAmountShouldEqualReservationPrice($price): void
    {
        if ($this->input('online') < $price) {
            throw ValidationException::withMessages([
                'online' => __(
                    "Paid Amount Doesn't equal to Reservation Price",
                ),
            ]);
        }
    }

    public function validateUserWalletHasTheDeductedAmount()
    {
        if (
            $this->input('wallet') != 0 &&
            $this->user()->CanPay($this->input('wallet'))
        ) {
            throw ValidationException::withMessages([
                'doctor_id' => __(
                    "Sorry, You Don't Have Enough Amount In Your Wallet To Make Reservation",
                ),
            ]);
        }
    }
}
