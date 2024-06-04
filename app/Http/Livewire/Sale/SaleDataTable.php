<?php

namespace App\Http\Livewire\Sale;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Batch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SaleDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = true;
    public $model = Sale::class;
    public $saledetails;
    public $batch;
    public $hideable = 'select';

    public function builder()
    {
        return (Sale::query()
            ->join('customers', function ($join) {
                $join->on('sales.customer_id', '=', 'customers.id');
            })
            ->join('people as sale_customer', function ($join) {
                $join->on('sale_customer.id', '=', 'customers.person_id');
            })
            ->join('customer_types', function ($join) {
                $join->on('customers.customer_type_id', '=', 'customer_types.id');
            })
            ->join('users', function ($join) {
                $join->on('sales.user_id', '=', 'users.id');
            })
            ->join('people as sale_user', function ($join) {
                $join->on('sale_user.id', '=', 'users.person_id');
            })
            ->where('sales.state', 'ACTIVE')
        );
    }

    public function columns()
    {
        return [
            Column::name('id')
                ->searchable()
                ->label('Código'),

            Column::name('sale_customer.name')
                ->searchable()
                ->label('Cliente'),

            Column::name('sale_customer.ci')
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


            Column::callback(['sale_user.name'], function ($name) {
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
                return view('livewire.sale.sale-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }

    public function cancelsale($id)
    {
        $this->saledetails = SaleDetail::all()->where('sale_id', $id);
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
            $Sale = Sale::find($this->idDelet);
            $this->cancelsale($this->idDelet);
            $Sale->state = "DELETED";
            $Sale->update();
        }
    }
}
