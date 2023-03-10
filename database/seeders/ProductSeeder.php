<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 50) as $item) {
            fake()->randomElement([
            \App\Models\Unit::factory(),
            \App\Models\Yardage::factory()
            ])->has(
                \App\Models\Product::factory()
                ->hasAttached(\App\Models\Category::inRandomOrder()->limit(rand(1, 2))->get())
            )->create();
        }

        \App\Models\Product::all()->each(fn($product) =>
            $product
                ->addMediaFromUrl(fake()->imageUrl(360, 360+100, 'Clothing', true, 'Skirts', true, 'jpg'))
                ->toMediaCollection('product-image')
        );


    }
}
