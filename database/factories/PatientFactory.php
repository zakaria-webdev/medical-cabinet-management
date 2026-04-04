<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'cin' => fake()->unique()->bothify('??######'), // بحال AB123456
            'telephone' => fake()->phoneNumber(),
            'date_naissance' => fake()->date('Y-m-d', '-18 years'), // باش يعطينا ناس كبار
            'sexe' => fake()->randomElement(['Homme', 'Femme']),
            'adresse' => fake()->address(),
        ];
    }
}
