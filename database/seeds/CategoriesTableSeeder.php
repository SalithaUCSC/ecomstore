<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops'
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'phones'
        ]);

        Category::create([
            'name' => 'Mobile Accessories',
            'slug' => 'mobile-accessories'
        ]);

        Category::create([
            'name' => 'TVs',
            'slug' => 'tv'
        ]);

        Category::create([
            'name' => 'Digital Cameras',
            'slug' => 'cameras'
        ]);

    }
}
