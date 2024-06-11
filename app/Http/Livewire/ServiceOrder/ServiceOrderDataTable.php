<?php

namespace App\Http\Livewire\ServiceOrder;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderBatch;
use App\Models\Batch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceOrderDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = true;
    public $model = ServiceOrder::class;
    public $saledetails;
    public $batch;
    public $hideable = 'select';

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
            ->where('service_orders.state', 'PENDING')
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

            Column::callback(['state'], function ($state) {
                return view('components.datatables.state-data-table', ['state' => $state]);
            })->exportCallback(function ($state) {
                $state == 'ACTIVE' ? $state = 'ACTIVO' : $state = 'INACTIVO';
                return (string)$state;
            })
                ->label('Estado')
                ->filterable([
                    'ACTIVE',
                    'INACTIVE'
                ]),

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::callback(['id', 'slug'], function ($id, $slug) {
                return view('livewire.service-order.service-order-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }

    public function cancelsale($id)
    {
        $this->saledetails = ServiceOrderBatch::all()->where('service_order_id', $id);
        foreach ($this->saledetails as $id_ => $item) {
            $this->batch = Batch::where('id', $item['batch_id'])->firstOrFail();
            $this->batch->update([
                'stock' => $this->batch->stock + $item['quantity'],
            ]);
        }
    }

    public $idDelet;

    public function toastConfirmDelet($id)
    {
        $this->idDelet = $id;
        $this->confirm(__('¿Estas seguro que seas anular el registro?'), [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'confirmButtonText' => 'Si',
            'showConfirmButton' => true,
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
        if ($this->idDelet) {
            $ServiceOrder = ServiceOrder::find($this->idDelet);
            $this->cancelsale($this->idDelet);
            $ServiceOrder->state = "DELETED";
            $ServiceOrder->update();
        }
    }
}
