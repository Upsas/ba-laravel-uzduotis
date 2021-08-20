<?php

namespace Database\Factories;

use App\Models\SharedContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class SharedContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SharedContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'contact_id' => $this->faker->numberBetween(1, 50),
           'contact_shared_user_id' =>  $this->faker->numberBetween(1, 10),
        ];
    }
}
