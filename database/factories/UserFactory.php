<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JumpGate\Users\Models\User\Status;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'             => $this->faker->name,
            'email'            => $this->faker->unique()->safeEmail,
            'password'         => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'status_id'        => Status::ACTIVE,
            'authenticated_at' => now(),
            'remember_token'   => Str::random(10),
        ];
    }

    /**
     * Create an inactive user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => Status::INACTIVE,
            ];
        });
    }

    /**
     * Create a blocked user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function blocked()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => Status::BLOCKED,
            ];
        });
    }
}
