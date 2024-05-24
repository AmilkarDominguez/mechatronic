<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Supplier::create([
            'name' => 'Proveedor A',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        Supplier::create([
            'name' => 'Proveedor B',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        Supplier::create([
            'name' => 'Proveedor C',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
