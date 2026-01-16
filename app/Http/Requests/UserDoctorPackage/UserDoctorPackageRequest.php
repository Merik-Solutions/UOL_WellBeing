<?php

declare(strict_types=1);

namespace App\Http\Requests\UserDoctorPackage;

use App\Criteria\IsActiveCriteria;
use App\Criteria\IsActiveCriteriaCriteria;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\PromocodeRepository;
use App\Repositories\interfaces\DoctorPackageRepository;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserDoctorPackageRequest extends FormRequest
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
        return (new UserDoctorPackage())->rules();
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['user_id'] = auth()->id();
        /** @var UserDoctorPackageRepository $repo */
        $doctor_package = app(DoctorPackageRepository::class)
            ->ofDoctor($this->doctor_id)
            ->ofPackage($this->package_id)
            ->first();
        $data['doctor_package_id'] = $doctor_package->id;
        $data['expired_at'] = Carbon::now()->addDays(
            $doctor_package->expires_in,
        );
        $data['price'] = $this->calcPrice($doctor_package->price);
        return $data;
    }

    public function calcPrice(float $price): float
    {
        if ($this->promocode_id) {
            /** @var \App\Models\Promocode $promocode */
            $promocode = app(PromocodeRepository::class)
                ->pushCriteria(IsActiveCriteria::class)
                ->forPackages()
                ->where('id', $this->promocode_id)
                ->firstOrNew();
            $price = $promocode->PriceAfterDiscount($price);
        }
        return $price;
    }


    public function validatePaidAmountShouldEqualPackagePrice($price): void
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
            $this->user()->CanPay((float) $this->input('wallet'))
        ) {
            throw ValidationException::withMessages([
                'doctor_id' => __(
                    "Sorry, You Don't Have Enough Amount In Your Wallet To Make Subscription",
                ),
            ]);
        }
    }
}
