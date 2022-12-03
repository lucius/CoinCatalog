<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonetaryPattern>
 */
class MonetaryPatternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $end = $this->faker->date();
        $start = $this->faker->date('Y-m-d', $end);

        return [
            'name' => $this->faker->unique()->word,
            'symbol' => $this->faker->unique()->randomLetter().'$',
            'start_date' => $start,
            'end_date' => $end,
        ];
    }

    public function current()
    {
        return $this->state(function (array $attributes) {
            return [
                'end_date' => null,
            ];
        });
    }

    public function startBeforeEnds()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => $attributes['end_date'],
                'end_date' => $attributes['start_date'],
            ];
        });
    }
}
