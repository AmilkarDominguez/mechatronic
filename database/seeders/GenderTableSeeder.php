<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Gender::create([
            'name' => 'MASCULINO',
            'state' => 'ACTIVE',
            'slug' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Gender::create([
            'name' => 'FEMENINO',
            'state' => 'ACTIVE',
            'slug' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
