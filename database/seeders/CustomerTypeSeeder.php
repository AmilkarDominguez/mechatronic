<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        CustomerType::create([
            'name' => 'Mayorista',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //2
        CustomerType::create([
            'name' => 'Minorista',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //3
        CustomerType::create([
            'name' => 'Constructora',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //4
        CustomerType::create([
            'name' => 'Final',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
