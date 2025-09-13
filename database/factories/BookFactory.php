<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $total = $this->faker->numberBetween(1, 5);
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'editorial' => $this->faker->company(),
            'isbn' => $this->faker->unique()->isbn13(),
            'publication_year' => $this->faker->year(),
            'total_copies' => $total,
            'available_copies' => $total,
            'description' => $this->faker->paragraph(),
        ];
    }
}
