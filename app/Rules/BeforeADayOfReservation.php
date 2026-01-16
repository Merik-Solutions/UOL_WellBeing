<?php

namespace App\Rules;

use App\Models\Reservation;
use App\Repositories\interfaces\ReservationRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class BeforeADayOfReservation implements Rule
{
    protected int $min_hours = 4;
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $reservation = app(ReservationRepository::class)->find($value, [
                'date',
                'from_time',
            ]);
        } catch (\Exception $e) {
            return false;
        }
        return $reservation->start_in >= $this->min_hours;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __(
            "Sorry , You Can't Cancel Reservation Before {$this->min_hours} Hours Of Appointment",
        );
    }
}
