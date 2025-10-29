<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CurrencyFactory extends Factory
{
    protected $model = \App\Models\Currency::class;

    public function definition()
    {
        $codes = ['IDR', 'USD', 'EUR', 'JPY', 'SGD'];

        return [
            'code' => $this->faker->unique()->randomElement($codes),
            'rate_to_base' => $this->faker->randomFloat(4, 0.0001, 15000),
            'fetched_at' => Carbon::now()->subDays(rand(0, 30)),
        ];
    }
}
