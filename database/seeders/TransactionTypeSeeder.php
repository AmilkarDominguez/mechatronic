<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //1
        TransactionType::create([
            'name' => 'Creación de cuenta bancaria.',
            'slug' => Str::uuid(),
            'type' => 'INGRESO',
            'state' => 'ACTIVE',
            'allow_deletion' => false
        ]);
        //2
        TransactionType::create([
            'name' => 'Deposito a cuenta bancaria.',
            'slug' => Str::uuid(),
            'type' => 'INGRESO',
            'state' => 'ACTIVE',
            'allow_deletion' => false
        ]);
        //3
        TransactionType::create([
            'name' => 'Retiro de cuenta bancaria.',
            'slug' => Str::uuid(),
            'type' => 'EGRESO',
            'state' => 'ACTIVE',
            'allow_deletion' => false
        ]);
        //4
        TransactionType::create([
            'name' => 'Compra lote de productos.',
            'slug' => Str::uuid(),
            'type' => 'EGRESO',
            'state' => 'ACTIVE',
            'allow_deletion' => false
        ]);
        //5
        TransactionType::create([
            'name' => 'Pago de orden de servicio.',
            'slug' => Str::uuid(),
            'type' => 'INGRESO',
            'state' => 'ACTIVE',
            'allow_deletion' => false
        ]);
    }
}
