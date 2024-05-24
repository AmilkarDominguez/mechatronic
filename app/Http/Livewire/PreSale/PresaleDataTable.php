<?php

namespace App\Http\Livewire\PreSale;

use App\Models\PreSale;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class PreSaleDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = PreSale::class;

    public $hideable = 'select';

    public function builder()
    {
        return (PreSale::query()
            ->join('customers', function ($join) {
                $join->on('pre_sales.customer_id', '=', 'customers.id');
            })
            ->join('people as pre_sale_customer', function ($join) {
                $join->on('pre_sale_customer.id', '=', 'customers.person_id');
            })
            ->join('customer_types', function ($join) {
                $join->on('customers.customer_type_id', '=', 'customer_types.id');
            })

            ->join('users', function ($join) {
                $join->on('pre_sales.user_id', '=', 'users.id');
            })
            ->join('people as pre_sale_user', function ($join) {
                $join->on('pre_sale_user.id', '=', 'users.person_id');
            })
            ->where('pre_sales.state', 'ACTIVE')
        );
    }

    public function columns()
    {
        return [
            Column::name('id')
                ->searchable()
                ->label('Código'),

            Column::name('pre_sale_customer.name')
                ->searchable()
                ->label('Cliente'),

            Column::name('pre_sale_customer.ci')
                ->searchable()
                ->label('CI'),

            Column::name('customers.nit')
                ->searchable()
                ->label('NIT'),

            Column::name('total')
                ->searchable()
                ->label('Total'),

            Column::name('pre_sale_user.name')
                ->searchable()
                ->label('Registrado por'),

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::callback(['id', 'slug'], function ($id, $slug) {
                return view('livewire.pre-sale.pre-sale-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }

    public $idDelet;
    public function toastConfirmDelet($id)
    {
        $this->idDelet = $id;
        $this->confirm(__('¿Estas seguro que seas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
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
        if ($this->idDelet) {
            $Presale = PreSale::find($this->idDelet);
            $Presale->state = "DELETED";
            $Presale->update();
        }
    }
}
