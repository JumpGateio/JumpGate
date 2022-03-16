<?php

namespace Database\Factories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JumpGate\Users\Models\User\Timestamp;

class TimestampsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timestamp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'             => User::factory(),
            'activated_at'        => $this->faker->dateTime,
            'invited_at'          => $this->faker->dateTime,
            'blocked_at'          => $this->faker->dateTime,
            'password_updated_at' => $this->faker->dateTime,
        ];
    }
}
