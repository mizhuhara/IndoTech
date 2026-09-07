<?php

namespace Database\Factories;

use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<University>
 */
class UniversityFactory extends Factory
{
    protected $model = University::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company().' University';

        return [
            'name' => $name,
            'npsn' => fake()->unique()->numerify('########'),
            'type' => fake()->randomElement(['Negeri', 'Swasta']),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'location' => fake()->city().', '.fake()->state(),
            'address' => fake()->address(),
            'status' => 'Active',
            'logo_url' => null,
            'logo_name' => null,
            'logo_text' => strtoupper(substr($name, 0, 3)),
            'logo_bg' => 'bg-blue-700',
            'email' => fake()->safeEmail(),
            'website' => fake()->url(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->paragraph(),
            'tags' => ['Teknik', 'Sains'],
            'total_students' => fake()->numberBetween(1000, 50000),
            'total_faculties' => fake()->numberBetween(5, 20),
            'accreditation' => 'A',
            'founded' => fake()->numberBetween(1945, 2020),
        ];
    }
}
