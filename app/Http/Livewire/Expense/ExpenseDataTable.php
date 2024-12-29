<?php

namespace App\Http\Livewire\Expense;

use App\Models\ExpenseType;
use App\Models\Expense;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ExpenseDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = Expense::class;
    public $hideable = 'select';

    public function builder()
    {
        return (Expense::query()
            ->where('expenses.state', '!=', 'DELETED')
            ->join('expense_types', function ($join) {
                $join->on('expense_types.id', '=', 'expenses.expense_type_id');
            }));
    }

    public function columns()
    {
        return [
            Column::name('purchase')
                ->searchable()
                ->label('Costo'),

            Column::name('expense_types.name')
                ->searchable()
                ->label('Tipo')
                ->alignRight(),

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
                    'ACTIVE',
                    'INACTIVE'
                ]),
            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::callback(['id', 'slug'], function ($id, $slug) {
                return view('livewire.expense.expense-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }

    public $idDelet;
    public function toastConfirmDelet($id)
    {
        $this->idDelet = $id;
        $this->confirm(__('¿Estás seguro que deseas eliminar el registro?'), [
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
            $Expense = Expense::find($this->idDelet);
            $Expense->state = "DELETED";
            $Expense->update();
        }
    }
}
