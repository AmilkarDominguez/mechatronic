<?php

namespace App\Http\Livewire\Reports\BatchStockReport;

use App\Models\Batch;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class BatchStockReportDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = false;
    public $model = Batch::class;
    public $persistSearch = false;
    public $persistComplexQuery = false;
    public $persistHiddenColumns = false;
    public $persistSort = false;
    public $persistPerPage = false;
    public $persistFilters = false;
    
    public $limit = 0;


    protected $listeners = ['setNumberLimit'];

    public function setNumberLimit($limit)
    {
        $this->limit = $limit;
    }

    public function builder()
    {
        return (Batch::query()
            ->where('batches.stock','<=', $this->limit)
            ->join('products', function ($join) {
                $join->on('products.id', '=', 'batches.product_id');
            })
        );
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
        ];
    }
}
