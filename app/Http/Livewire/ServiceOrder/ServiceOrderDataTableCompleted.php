<?php

namespace App\Http\Livewire\ServiceOrder;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderBatch;
use App\Models\Batch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceOrderDataTableCompleted extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = true;
    public $model = ServiceOrder::class;
    public $saledetails;
    public $batch;
    public $hideable = 'select';

    public $selectedId;

    public function builder()
    {
        return (ServiceOrder::query()
            ->join('customers', function ($join) {
                $join->on('service_orders.customer_id', '=', 'customers.id');
            })
            ->join('people as service_order_customer', function ($join) {
                $join->on('service_order_customer.id', '=', 'customers.person_id');
            })
            ->join('customer_types', function ($join) {
                $join->on('customers.customer_type_id', '=', 'customer_types.id');
            })
            ->join('users', function ($join) {
                $join->on('service_orders.user_id', '=', 'users.id');
            })
            ->join('people as service_order_user', function ($join) {
                $join->on('service_order_user.id', '=', 'users.person_id');
            })
            ->where('service_orders.state', 'COMPLETED')
        );
    }

    public function columns()
    {
        return [
            Column::name('id')
                ->searchable()
                ->label('Código'),

            Column::name('service_order_customer.name')
                ->searchable()
                ->label('Cliente'),

            Column::name('service_order_customer.ci')
                ->searchable()
                ->label('CI'),

            Column::name('customers.nit')
                ->searchable()
                ->label('NIT'),

            Column::name('have')
                ->searchable()
                ->label('Haber'),

            Column::name('must')
                ->searchable()
                ->label('Debe'),

            Column::name('total')
                ->searchable()
                ->label('Total'),


            Column::callback(['service_order_user.name'], function ($name) {
                return $name;
            })->exportCallback(function ($name) {
                return (string)$name;
            })
                ->searchable()
                ->label('Registrado por'),


            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            // Column::callback(['id', 'slug'], function ($id, $slug) {
            //     return view('livewire.service-order.service-order-table-actions', ['id' => $id, 'slug' => $slug]);
            // })->label('Opciones')
            //     ->excludeFromExport()

        ];
    }

}
