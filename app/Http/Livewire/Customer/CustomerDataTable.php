<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use App\Models\Person;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CustomerDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = Customer::class;

    public $hideable = 'select';


    public function builder()
    {

        return (Customer::query()
            ->where('customers.state', '!=', 'DELETED')
            ->join('people as person', function ($join) {
                $join->on('person.id', '=', 'customers.person_id');
            }));
    }

    public function columns()
    {
        return [
            Column::name('person.name')
                ->searchable()
                ->label('Nombre completo')
                ->alignRight(),

            Column::name('person.address')
                ->searchable()
                ->label('Dirección')
                ->alignRight(),

            Column::name('description')
                ->searchable()
                ->label('Description')
                ->alignRight(),

            Column::name('email')
                ->searchable()
                ->label('Correo electrónico')
                ->alignRight(),

            Column::name('customers.nit')
                ->searchable()
                ->label('Nit'),

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

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::callback(['id', 'slug'], function ($id, $slug) {
                return view('livewire.customer.customer-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()


        ];
    }

    public $idDelet;
    public function toastConfirmDelet($id)
    {
        $this->idDelet = $id;
        $this->confirm(__('¿Estás seguro que seas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  'Cliente con el Id  ' . $id,
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
            $Customer = Customer::find($this->idDelet);
            $Customer->state = "DELETED";
            $Customer->update();
            //$Consignment->delete();
        }
    }
}
