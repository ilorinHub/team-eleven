<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
          ['name' => 'accessories', 'slug' => str()->slug('accessories')],
          ['name' => 'casual', 'slug' => str()->slug('casual')],
          ['name' => 'children and infants', 'slug' => str()->slug('children and infants')],
          ['name' => 'fabrics', 'slug' => str()->slug('fabrics')],
          ['name' => 'formal', 'slug' => str()->slug('formal')],
          ['name' => 'garments', 'slug' => str()->slug('garments')],
          ['name' => 'men', 'slug' => str()->slug('men')],
          ['name' => 'native', 'slug' => str()->slug('native')],
          ['name' => 'outfits', 'slug' => str()->slug('outfits')],
          ['name' => 'religious', 'slug' => str()->slug('religious')],
          ['name' => 'women', 'slug' => str()->slug('women')]

        ]);
    }
}
