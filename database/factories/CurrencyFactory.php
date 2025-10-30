<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CurrencyFactory extends Factory
{
    protected $model = \App\Models\Currency::class;

    public function definition()
    {
        $currencies = [
            'IDR' => 'Indonesian Rupiah',
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'JPY' => 'Japanese Yen',
            'SGD' => 'Singapore Dollar',
        ];

        $code = $this->faker->unique()->randomElement(array_keys($currencies));

        return [
            'code' => $code,
            'name' => $currencies[$code],
            'rate_to_base' => $this->faker->randomFloat(4, 0.0001, 15000),
            'fetched_at' => now()->subDays(rand(0, 30)),
        ];
    }
}
