<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Industry::create([
            'name' => 'Argentina',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        Industry::create([
            'name' => 'Bolivia',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        Industry::create([
            'name' => 'Brasil',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
