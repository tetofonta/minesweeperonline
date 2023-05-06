<?php

namespace Database\Factories;

use App\Models\EmailCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<EmailCode>
 */
class EmailCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'token' => bin2hex(random_bytes(24))
        ];
    }

}
