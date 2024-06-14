<?php

namespace Database\Seeders;

use App\Models\ExtraItem;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Str;
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
        Product::create([
            'category_id' => 1,
            'presentation_id' => 1,
            'name' => 'Aceite',
            'code' => '898989',
            'description' => 'Aceite de 1 L Moto 4T',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        Service::create([
            'name'=>'Mantenimiento moto basico A',
            'code'=> 'MMA',
            'description' => 'Mantenimiento moto china basico',
            'price' => 190,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        Service::create([
            'name'=>'Mantenimiento moto intermedio B',
            'code'=> 'MMB',
            'description' => 'Mantenimiento moto china intermedio',
            'price' => 220,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        Service::create([
            'name'=>'Mantenimiento moto completo C',
            'code'=> 'MMC',
            'description' => 'Mantenimiento moto china completo',
            'price' => 250,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        ExtraItem::create([
            'name'=>'Tapizado de interior',
            'cost'=> 800,
            'price' => 1500,
            'description' => 'Tapizado de interior',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        ExtraItem::create([
            'name'=>'Tapizado de volante',
            'cost'=> 300,
            'price' => 450,
            'description' => 'Tapizado de volante',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        ExtraItem::create([
            'name'=>'Soldadura de escape',
            'cost'=> 500,
            'price' => 650,
            'description' => 'Soldadura de escape',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
