<?php

namespace Database\Factories;

use App\Models\DailyPassword;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyPasswordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyPassword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'password' => $this->faker->password,
            'password2' => $this->faker->password,
        ];
    }
}
