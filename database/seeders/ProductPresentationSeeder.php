<?php

namespace Database\Seeders;

use App\Models\ProductPresentation;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductPresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        ProductPresentation::create([
            'name' => 'Litro',
            'code' => 'L',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //2
        ProductPresentation::create([
            'name' => 'Juego',
            'code' => 'Juego',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //3
        ProductPresentation::create([
            'name' => 'Caja',
            'code' => 'C',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        
    }
}
