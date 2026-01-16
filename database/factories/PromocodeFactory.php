<?php

namespace Database\Factories;

use App\Models\Promocode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromocodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promocode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "code" => $this->faker->word(),
            "type" => $this->faker->randomElement([1, 2]),
            "expired_at" => null,
            "use_time" => null,
            "percent" => $this->faker->numberBetween(1, 99),
        ];
    }
}
