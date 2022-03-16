<?php

namespace Database\Factories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JumpGate\Users\Models\User\Token;

class TokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Token::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type'    => $this->faker->randomElement([
                Token::TYPE_INVITATION,
                Token::TYPE_ACTIVATION,
                TOKEN::TYPE_PASSWORD_RESET,
            ]),
            'token'   => Token::makeToken('testing'),
        ];
    }
}
