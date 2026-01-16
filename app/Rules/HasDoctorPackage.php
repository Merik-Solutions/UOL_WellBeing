<?php

namespace App\Rules;

use App\Criteria\IsActiveCriteria;
use App\Models\Chat;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\ChatRepository;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\ValidationException;

class HasDoctorPackage implements Rule
{
    protected $doctor_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($doctor_id = null, $chat_id = null)
    {
        $this->chat_id = $chat_id;
        if (is_null($doctor_id)) {
            try {
                $doctor_id = app(ChatRepository::class)->find($chat_id, [
                    'doctor_id',
                ])->doctor_id;
            } catch (Exception $e) {
                throw ValidationException::withMessages([
                    'chat_id' => 'Chat Not Found',
                ]);
            }
        }
        $this->doctor_id = $doctor_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return app(UserDoctorPackageRepository::class)
            ->pushCriteria(IsActiveCriteria::class)
            ->ofDoctor($this->doctor_id)
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "'You Don't Have Subscription For This Doctor Please Make One";
    }
}
