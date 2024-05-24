<?php

namespace App\Http\Livewire\SaleExpense;

use App\Models\ExpenseType;
use App\Models\Expense;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ExpenseDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = false;
    public $model = Expense::class;
    public $persistSearch = false;
    public $persistComplexQuery = false;
    public $persistHiddenColumns = false;
    public $persistSort = false;
    public $persistPerPage = false;
    public $persistFilters = false;
    public $start_date;
    public $end_date;


    protected $listeners = ['setDates'];

    public function setDates($start, $end)
    {
        $this->start_date = $start;
        $this->end_date = $end;
    }

    public function builder()
    {
        return (Expense::query()
            ->whereBetween('expenses.created_at', [$this->start_date, $this->end_date])
            ->where('expenses.state', '!=', 'DELETED')
            ->join('expense_types', function ($join) {
                $join->on('expense_types.id', '=', 'expenses.expense_type_id');
            })
        );
    }

    public function columns()
    {
        return [
            Column::name('id')
                ->searchable()
                ->label('Código'),

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

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

        ];
    }


}
