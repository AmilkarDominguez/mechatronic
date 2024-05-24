<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WarehouseDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = ProductCategory::class;
    

    public function builder()
    {
        return Warehouse::query()->where('state', '!=', 'DELETED');
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
                return view('livewire.warehouse.warehouse-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()
        ];
    }

    public $WarehouseDeleted;
    public function toastConfirmDelet($slug)
    {
        $this->WarehouseDeleted = Warehouse::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->WarehouseDeleted->name,
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
        if ($this->WarehouseDeleted) {
            //Asignando estado DELETED
            $this->WarehouseDeleted->state = "DELETED";
            //Guardando el registro
            $this->WarehouseDeleted->update();
        }
    }
}
