<?php

namespace App\Http\Livewire\SaleExpense;

use App\Models\Expense;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderBatch;
use App\Models\Batch;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SaleDataTable extends LivewireDatatable
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
        return (ServiceOrder::query()
            ->whereBetween('service_orders.created_at', [$this->start_date, $this->end_date])
            ->join('customers', function ($join) {
                $join->on('service_orders.customer_id', '=', 'customers.id');
            })
            ->join('people as sale_customer', function ($join) {
                $join->on('sale_customer.id', '=', 'customers.person_id');
            })
            ->join('users', function ($join) {
                $join->on('service_orders.user_id', '=', 'users.id');
            })
            ->join('people as sale_user', function ($join) {
                $join->on('sale_user.id', '=', 'users.person_id');
            })
            ->where('service_orders.state', 'ACTIVE')
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

            Column::name('have')
                ->searchable()
                ->label('Haber'),

            Column::name('must')
                ->searchable()
                ->label('Debe'),

            Column::name('total')
                ->searchable()
                ->label('Total'),

            Column::name('sale_user.name')
                ->searchable()
                ->label('Registrado por'),


            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

        ];
    }

}
