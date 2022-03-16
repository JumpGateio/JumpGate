<?php

namespace Database\Factories\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use JumpGate\Users\Models\User\Status;

class StatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Status::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'  => $this->faker->unique()->name,
            'label' => $this->faker->name,
        ];
    }
}
