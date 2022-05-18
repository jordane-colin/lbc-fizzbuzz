<?php

namespace Database\Factories;

use App\Models\Stats;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StatsFactory extends Factory
{
    protected $model = Stats::class;

    public function definition(): array
    {
        return [
            'hash_request' => $this->faker->unique()->userName()
        ];
    }
}
