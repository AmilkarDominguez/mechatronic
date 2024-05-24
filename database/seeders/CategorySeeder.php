<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        ProductCategory::create([
            'name' => 'Catergoria 1',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //2
        ProductCategory::create([
            'name' => 'Catergoria 2',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //3
        ProductCategory::create([
            'name' => 'Catergoria 3',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
