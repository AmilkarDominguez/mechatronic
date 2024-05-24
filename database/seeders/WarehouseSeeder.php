<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        Warehouse::create([
            'name' => 'Almacen 1',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //2
        Warehouse::create([
            'name' => 'Almacen 2',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //3
        Warehouse::create([
            'name' => 'Almacen 3',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
