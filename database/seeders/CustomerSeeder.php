<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Person;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Person1 = Person::create([
            'ci' => 101010,
            'name' => 'Juan Garcia',
            'expedition_ci' => 'TJ',
            'address' => 'Av. Tarija 123',
        ]);
        $Customer1 = Customer::create([
            'customer_type_id' => 1,
            'person_id' => $Person1->id,
            'email' => 'jhondoe@email.com',
            'nit' => 123456,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        Vehicle::create([
            'brand' => 'SUZUKI',
            'model' => 'Vitara',
            'displacement' => '',
            'license_plate' => '101010',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
            'customer_id' => $Customer1->id,
        ]);


        $Person2 = Person::create([
            'ci' => 202020,
            'name' => 'Maria Figueroa Flores',
            'expedition_ci' => 'TJ',
            'address' => 'Av. Tarija 123',
        ]);
        $Customer2 = Customer::create([
            'customer_type_id' => 2,
            'person_id' => $Person2->id,
            'email' => 'maria@email.com',
            'nit' => 789456,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        Vehicle::create([
            'brand' => 'SUZUKI',
            'model' => 'Vitara',
            'displacement' => '',
            'license_plate' => '202020',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
            'customer_id' => $Customer2->id,
        ]);

        $Person3 = Person::create([
            'ci' => 101010,
            'name' => 'Gabriela Llanos Tejerina',
            'expedition_ci' => 'TJ',
            'address' => 'Av. Tarija 123',
        ]);
        
        $Customer3 = Customer::create([
            'customer_type_id' => 3,
            'person_id' => $Person3->id,
            'email' => 'gabriela@email.com',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);

        Vehicle::create([
            'brand' => 'SUZUKI',
            'model' => 'Vitara',
            'displacement' => '',
            'license_plate' => '303030',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
            'customer_id' => $Customer3->id,
        ]);

        $Person4 = Person::create([
            'ci' => 101010,
            'name' => 'Carlos Medina Rodriguez',
            'expedition_ci' => 'TJ',
            'address' => 'Av. Tarija 123',
        ]);
        $Customer4 = Customer::create([
            'customer_type_id' => 3,
            'person_id' => $Person4->id,
            'email' => 'carlos@email.com',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        Vehicle::create([
            'brand' => 'SUZUKI',
            'model' => 'Vitara',
            'displacement' => '',
            'license_plate' => '404040',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
            'customer_id' => $Customer4->id,
        ]);
        //Employes
        $Employe1 = Person::create([
            'ci' => 11111,
            'name' => 'Leonel Rojas Campos',
            'expedition_ci' => 'TJ',
            'address' => 'Av. Tarija 123',
        ]);
        Employee::create([
            'person_id' => $Employe1->id,
            'nit' => 11111,
            'description' => '',
            'email' => 'email@email.com',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
        
        $Employe2 = Person::create([
            'ci' => 11111,
            'name' => 'Mauricio Torrez Llanos',
            'expedition_ci' => 'TJ',
            'address' => 'Av. Tarija 123',
        ]);
        Employee::create([
            'person_id' => $Employe2->id,
            'nit' => 11111,
            'description' => '',
            'email' => 'email@email.com',
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
        ]);
    }
}
