<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //1
        BankAccount::create([
            'name' => 'Cuenta principal BCP',
            'description' => 'Cuenta principal BCP',
            'number' => '10101010',
            'balance' => '5000',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        //2
        BankAccount::create([
            'name' => 'Cuenta principal Bisa',
            'description' => 'Cuenta principal Bisa',
            'number' => '20202020',
            'balance' => '2000',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
