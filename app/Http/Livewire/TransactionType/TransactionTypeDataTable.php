<?php

namespace App\Http\Livewire\TransactionType;

use App\Models\TransactionType;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TransactionTypeDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = TransactionType::class;
    public $hideable = 'select';

    public function builder()
    {
        return TransactionType::query()->where('state', '!=', 'DELETED');
    }

    public function columns()
    {
        return [
            Column::name('name')
                ->searchable()
                ->label('Nombre'),

            Column::name('description')
                ->searchable()
                ->label('Descripción'),

            Column::callback(['type'], function ($type) {
                return view('components.datatables.transaction-type-data-table', ['type' => $type]);
            })
                ->exportCallback(function ($type) {
                    $type == 'INGRESO' ? $type = 'INGRESO' : $type = 'EGRESO';
                    return (string) $type;
                })
                ->label('Tipo')
                ->filterable([
                    'INGRESO',
                    'EGRESO'
                ]),

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

            Column::callback(['id', 'slug', 'name', 'allow_deletion'], function ($id, $slug, $name, $allow_deletion) {
                return view(
                    'livewire.transaction-type.transaction-type-table-actions',
                    [
                        'id' => $id,
                        'slug' => $slug,
                        'name' => $name,
                        'allow_deletion' => $allow_deletion,
                    ]
                );
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }

    public $idDelet;
    public function toastConfirmDelet($name, $id)
    {
        $this->idDelet = $id;
        $this->confirm(__('¿Estás seguro que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $name,
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
            $TransactionType = TransactionType::find($this->idDelet);
            $TransactionType->state = "DELETED";
            $TransactionType->update();
        }
    }
}
