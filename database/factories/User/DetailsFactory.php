<?php

namespace Database\Factories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JumpGate\Users\Models\User\Details;

class DetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Details::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'      => User::factory(),
            'first_name'   => $this->faker->firstName,
            'middle_name'  => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'display_name' => $this->faker->userName,
            'timeszone'    => $this->faker->timezone,
            'location'     => $this->faker->city,
            'url'          => $this->faker->url,
        ];
    }
}
