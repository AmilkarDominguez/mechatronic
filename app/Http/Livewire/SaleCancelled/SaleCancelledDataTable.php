<?php


namespace App\Http\Livewire\SaleCancelled;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderBatch;
use App\Models\Batch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class SaleCancelledDataTable extends LivewireDatatable
{
    public $model = ServiceOrder::class;
    public $saledetails;
    public $batch;
    public $hideable = 'select';

    public function builder()
    {
        return (ServiceOrder::query()
            ->join('customers', function ($join) {
                $join->on('sales.customer_id', '=', 'customers.id');
            })

            ->join('people as person', function ($join) {
                $join->on('person.id', '=', 'customers.person_id');
            })
            ->join('customer_types', function ($join) {
                $join->on('customers.customer_type_id', '=', 'customer_types.id');
            })
            ->where('customer_types.name',  'profesional')
            ->where('sales.state', 'DELETED'));
    }

    public function columns()
    {
        return [
            Column::name('id')
                ->searchable()
                ->label('Código'),

            Column::name('person.name')
                ->searchable()
                ->label('Cliente'),

            Column::name('total')
                ->searchable()
                ->label('Total'),

            DateColumn::name('created_at')
                ->label('Fecha')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::callback(['id', 'slug'], function ($id, $slug) {
                return view('livewire.service_order-cancelled.service_order-cancelled-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }
}
