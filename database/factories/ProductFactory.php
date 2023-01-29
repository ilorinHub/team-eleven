<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Product\Utilities\ProductSkuService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sku = new ProductSkuService();
        $name = fake()->unique()->words(3, true);
        $priceable = fake()->randomElement([
            \App\Models\Unit::factory(),
            \App\Models\Yardage::factory(),
        ]);
        return [
            'sku' => $sku->generate(),
            'name' => $name,
            'slug' => str()->slug($name),
            'priceable_id' => '',
            'priceable_type' => '',
        ];
    }
}
