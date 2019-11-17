<?php

use App\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::create([
            'name' => 'Apple'
        ]);

        Brand::create([
            'name' => 'Dell'
        ]);

        Brand::create([
            'name' => 'Remax'
        ]);

        Brand::create([
            'name' => 'Samsung'
        ]);

        Brand::create([
            'name' => 'Huawei'
        ]);
    }
}
