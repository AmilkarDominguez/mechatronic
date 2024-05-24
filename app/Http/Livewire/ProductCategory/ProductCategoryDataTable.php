<?php

namespace App\Http\Livewire\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class ProductCategoryDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = true;
    public $model = ProductCategory::class;
    

    public function builder()
    {
        return ProductCategory::query()->where('state', '!=', 'DELETED');
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
                return view('livewire.product-category.product-category-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()
        ];
    }

    public $productcategoryDeleted;
    public function toastConfirmDelet($slug)
    {
        $this->productcategoryDeleted = ProductCategory::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->productcategoryDeleted->name,
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
        if ($this->productcategoryDeleted) {
            //Asignando estado DELETED
            $this->productcategoryDeleted->state = "DELETED";
            //Guardando el registro
            $this->productcategoryDeleted->update();
        }
    }
}
