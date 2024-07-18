<?php

namespace App\Http\Livewire\Vehicle;

use App\Models\Vehicle;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class VehicleDataTable extends LivewireDatatable
{
    //Using de alert
    use LivewireAlert;
    public $exportable = true;
    public $model = Vehicle::class;


    public function builder()
    {
        return Vehicle::query()->where('state', '!=', 'DELETED');
    }
    public function columns()
    {
        return [

            Column::name('license_plate')
                ->searchable()
                ->label('Placa'),

            Column::name('brand')
                ->searchable()
                ->label('Marca'),

            Column::name('model')
                ->searchable()
                ->label('Model'),

            Column::name('displacement')
                ->searchable()
                ->label('Cilindrada  '),

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
                return view('livewire.vehicle.vehicle-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()
        ];
    }

    public $VehicleDeleted;
    public function toastConfirmDelet($slug)
    {
        $this->VehicleDeleted = Vehicle::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->VehicleDeleted->name,
            'confirmButtonText' =>  'Si',
            'showConfirmButton' =>  true,
            'showCancelButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',
        ]);
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        if ($this->VehicleDeleted) {
            $this->VehicleDeleted->state = "DELETED";
            $this->VehicleDeleted->update();
        }
    }
}
