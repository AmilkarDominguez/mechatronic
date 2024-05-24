<?php

namespace App\Http\Livewire\Country;

use Livewire\Component;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CountryDataTable extends LivewireDatatable
{
     //Using de alert
     use LivewireAlert;

     public $exportable = true;
     public $model = Country::class;
     
 
     public function builder()
     {
         return Country::query()->where('state', '!=', 'DELETED');
     }
     public function columns()
     {
         return [
 
             Column::name('name')
                 ->searchable()
                ->label('Nombre'),      
 
             Column::callback(['state'], function ($state) {
                 return view('components.datatables.state-data-table', ['state' => $state]);
             })
                 ->exportCallback(function ($state) {
                     $state == 'ACTIVE' ? $state = 'ACTIVO' : $state = 'INACTIVO';
                     return (string) $state;
                 })
                 ->label('Estado')
                 ->filterable([
                     'ACTIVE',
                     'INACTIVE'
                 ]),
 
             Column::callback(['slug'], function ($slug) {
                 return view('livewire.country.country-table-actions', ['slug' => $slug]);
             })->label('Opciones')
                 ->excludeFromExport()
         ];
     }
 
     public $CountryDeleted;
     public function toastConfirmDelet($slug)
     {
         $this->CountryDeleted = Country::where('slug', $slug)->first();
         $this->confirm(__('¿Estas seguro que seas eliminar el registro?'), [
             'icon' => 'warning',
             'position' =>  'center',
             'toast' =>  false,
             'text' =>  $this->CountryDeleted->name,
             'confirmButtonText' =>  'Si',
             'showConfirmButton' =>  true,
             'showCancelButton' => true,
             'onConfirmed' => 'confirmed',
             'confirmButtonColor' => '#A5DC86',
         ]);
     }
     // Listener para eliminar
     protected $listeners = [
         'confirmed',
     ];
     //Funcion para confirmar la eliminacion
     public function confirmed()
     {
         if ($this->CountryDeleted) {
             //Asignando estado DELETED
             $this->CountryDeleted->state = "DELETED";
             //Guardando el registro
             $this->CountryDeleted->update();
         }
     }
}
