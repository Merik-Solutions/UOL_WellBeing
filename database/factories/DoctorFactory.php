<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "title_ar" => $this->faker->word(),
            "title_en" => $this->faker->word(),
            "description_ar" => $this->faker->sentence(),
            "description_en" => $this->faker->sentence(),
            "email" => $this->faker->email(),
            "password" => $this->faker->word(),
            "phone" => $this->faker->phoneNumber(),
            "expirence" => $this->faker->randomNumber(),
            "category_id" => Category::inRandomOrder()->first(),
            "heal_cases" => [
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence(),
                $this->faker->sentence(),
            ],
            "price" => $this->faker->randomNumber(),
            "period" => [20, 30, 60][$this->faker->numberBetween(0, 2)],

            "gender" => $this->faker->numberBetween(0, 1),
            "image" => $this->faker->imageUrl(),
        ];
    }
}
