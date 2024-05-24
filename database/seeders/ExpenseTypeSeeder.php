<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        ExpenseType::create([
            'name' => 'Compra lote de productos.',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
