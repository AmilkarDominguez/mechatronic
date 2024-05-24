<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        Batch::create([
            'product_id' => 1,
            'warehouse_id' => 1,
            'supplier_id' => 1,
            'industry_id' => 1,
            'description' => 'Aceite Motul',
            //precios
            'wholesale_price' => 15.00,
            'retail_price' => 17.00,
            'final_price' => 25.00,
            'stock' => 20,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //2
        Batch::create([
            'product_id' => 1,
            'warehouse_id' => 1,
            'supplier_id' => 2,
            'industry_id' => 2,
            'description' => 'Aceite Mobil',
            //precios
            'wholesale_price' => 13.00,
            'retail_price' => 16.00,
            'final_price' => 20.00,
            'stock' => 15,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //3
        Batch::create([
            'product_id' => 1,
            'warehouse_id' => 1,
            'supplier_id' => 1,
            'industry_id' => 1,
            'description' => 'Aceite Lubrax',
            //precios
            'wholesale_price' => 35.00,
            'retail_price' => 41.00,
            'final_price' => 50.00,
            'stock' => 10,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
