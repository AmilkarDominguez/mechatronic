<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IdentityDocumentType;
use Illuminate\Support\Str;
class IdendityDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IdentityDocumentType::create([
            'name' => 'C.I.',
            'description' => 'Cédula de Identidad',
            'state' => 'ACTIVE',
            'slug' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        IdentityDocumentType::create([
            'name' => 'NIT',
            'description' => 'Número de Identifican Tributaria',
            'state' => 'ACTIVE',
            'slug' => Str::uuid(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //Factory Identity Document Type
        //IdentityDocumentType::factory(1000)->create();
    }
}
