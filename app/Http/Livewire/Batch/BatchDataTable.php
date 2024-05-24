<?php

namespace App\Http\Livewire\Batch;

use App\Models\Batch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BatchDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = ProductCategory::class;
    public $persistSearch = false;
    public $persistComplexQuery = false;
    public $persistHiddenColumns = false;
    public $persistSort = false;
    public $persistPerPage = false;
    public $persistFilters = false;


    public function builder()
    {
        return (Batch::query()
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'batches.product_id');
            }));
    }
    public function columns()
    {
        return [


            Column::name('products.code')
                ->searchable()
                ->defaultSort('desc')
                ->label('COD'),

            Column::name('id')
                ->searchable()
                ->defaultSort('desc')
                ->label('COD-Lote'),

            Column::name('products.name')
            ->searchable()
            ->label('Producto'),

            Column::callback(['stock'], function ($stock) {
                return view('livewire.batch.batch-stock', ['stock' => $stock]);
            })
                ->label('Stock'),

            DateColumn::name('expiration_date')
                ->label('Fecha expiración')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::name('description')
                ->searchable()
                ->label('Descripción'),

            Column::callback(['state'], function ($state) {
                return view('components.datatables.state-data-table', ['state' => $state]);
            })
                ->exportCallback(function ($state) {
                    $state == 'ACTIVE' ? $state = 'ACTIVO' : $state = 'INACTIVO';
                    return (string) $state;
                })
                ->label('Estado')
                ->filterable([
                    'ACTIVE'=>'ACTIVO',
                    'INACTIVE'=>'INACTIVO'
                ]),

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),


            Column::callback(['slug'], function ($slug) {
                return view('livewire.batch.batch-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()
        ];
    }

    public $BatchDeleted;
    public function toastConfirmDelet($slug)
    {
        $this->BatchDeleted = Batch::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->BatchDeleted->id,
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
        if ($this->BatchDeleted) {
            //Asignando estado DELETED
            $this->BatchDeleted->state = "DELETED";
            //Guardando el registro
            $this->BatchDeleted->update();
        }
    }
}
