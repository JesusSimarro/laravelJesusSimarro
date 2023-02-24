<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => User::factory(),
            "title" => $this->faker->text(50),
            "content" => $this->faker->text(500),
            "created_at" => now() //no hace falta
        ];
    }
}
