<?php

namespace Database\Factories;

use App\Models\User;
use DateInterval;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $create = fake()->dateTime();
        $finish = DateTimeImmutable::createFromMutable($create)->add(DateInterval::createFromDateString('+' . fake()->numberBetween(3, 600) . ' minutes'));

        return [
            "width" => fake()->randomElement([8, 16, 30]),
            "height" => fake()->randomElement([8, 16, 16]),
            "bombs" => fake()->randomElement([10, 32, 99]),
            "seed" => fake()->numberBetween(),
            "limit" => fake()->numberBetween(),
            "ranked" => fake()->boolean(),
            "status" => fake()->randomElement(["abandoned", "won", "lost"]),
            "state" => "---/---/---",
            "created_at" => $create,
            "finished_at" => $finish
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'last_login' => null
        ]);
    }
}
