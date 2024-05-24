<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Person;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //ROLES
        $admin = new Role();
        $admin->name = 'admin';
        $admin->description = 'Administrator';
        $admin->save();

        //VENTAS
        $sales = new Role();
        $sales->name = 'sales';
        $sales->description = 'Ventas';
        $sales->save();

        //INVENTARIO
        $inventory = new Role();
        $inventory->name = 'inventory';
        $inventory->description = 'Inventario';
        $inventory->save();

        //employee
        $employee = new Role();
        $employee->name = 'employee';
        $employee->description = 'Técnico';
        $employee->save();


        //CREDENCIALES PARA ADMIN
        $persona = Person::create([
            'name' => 'admin',
            'lastname' => ''
        ]);
        $Admin = User::create([
            'person_id' => $persona->id,
            'email' => 'admin@admin.com',
            'state' => 'ACTIVE',
            'email_verified_at' => now(),
            'slug' => Str::uuid(),
            'password' => bcrypt('Tarija_*'),
            'remember_token' => Str::random(10),
        ]);
        $Admin->roles()->attach($admin);

        //CREDENCIALES PARA USUARIOS

        // 1
        // $person = Person::create([
        //     'name' => 'Cristian',
        //     'lastname' => 'Quintana Aparicio',
        //     'ci' => '10308975'
        // ]);
        // $user = User::create([
        //     'person_id' => $person->id,
        //     'email' => 'cristianq@chavezcalla.com',
        //     'state' => 'ACTIVE',
        //     'email_verified_at' => now(),
        //     'slug' => Str::uuid(),
        //     'password' => bcrypt('CHeYOv+batR7nav&Phaz'),
        //     'remember_token' => Str::random(10),
        // ]);
        // $user->roles()->attach($sales);


        // //2
        // $person = Person::create([
        //     'name' => 'Cristhian',
        //     'lastname' => 'Chávez Calla',
        //     'ci' => '7123431',
        //     'expedition_ci' => 'TJ',
        // ]);
        // $user = User::create([
        //     'person_id' => $person->id,
        //     'email' => 'cchavez@chavezcalla.com',
        //     'state' => 'ACTIVE',
        //     'email_verified_at' => now(),
        //     'slug' => Str::uuid(),
        //     'password' => bcrypt('CHeYOv+batR7nav&Phaz'),
        //     'remember_token' => Str::random(10),
        // ]);
        // $user->roles()->attach($admin);

        // //3
        // $person = Person::create([
        //     'name' => 'Yanety Delicia',
        //     'lastname' => 'Chavarría Quispe',
        //     'ci' => '5036182',
        //     'expedition_ci' => 'TJ',
        // ]);
        // $user = User::create([
        //     'person_id' => $person->id,
        //     'email' => 'ychavarria@chavezcalla.com',
        //     'state' => 'ACTIVE',
        //     'email_verified_at' => now(),
        //     'slug' => Str::uuid(),
        //     'password' => bcrypt('CHeYOv+batR7nav&Phaz'),
        //     'remember_token' => Str::random(10),
        // ]);
        // $user->roles()->attach($sales);
    }
}
