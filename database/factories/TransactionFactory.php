<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $reservation = Reservation::inRandomOrder()->first();
        return [
            "billable_type" => Reservation::class,
            "billable_id" => $reservation->id,
            "sender_type" => \App\Models\User::class,
            "sender_id" => $reservation->user_id,
            "receiver_type" => Doctor::class,
            "receiver_id" => $reservation->doctor_id,
            "gateway" => "wallet",
            "amount" => $this->faker->numberBetween(10, 40),
            "currency" => "USD",
        ];
    }

    public function forDoctor($doctor_id)
    {
        return $this->state(function (array $attributes) use ($doctor_id) {
            return [
                "receiver_id" => $doctor_id,
            ];
        });
    }
}
