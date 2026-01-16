<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\WithdrawRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class WithdrawRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WithdrawRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "doctor_id" => Doctor::query()
                ->inRandomOrder()
                ->first()->id,
            "amount" => $this->faker->randomNumber(),
            "status" => $this->faker->randomElement([
                "waiting",
                "refused",
                "accepted",
            ]),
            "answered_by" => Admin::query()
                ->inRandomOrder()
                ->first()->id,
            "transaction_id" => Admin::query()
                ->inRandomOrder()
                ->first()->id,
            "notes" => $this->faker->word(),
        ];
    }

    public function ofDoctor($doctor_id)
    {
        return $this->state(function (array $attributes) use ($doctor_id) {
            return [
                "doctor_id" => $doctor_id,
            ];
        });
    }
}
