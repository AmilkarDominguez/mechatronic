<?php

namespace App\Http\Livewire\SaleExpense;

use App\Models\Expense;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class SaleExpenseDashboard extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;

    public $expenses_total;
    public $sales_total;
    public $utility;

    public function mount()
    {
//        $this->start_date = Carbon::now()->subMonth()->format('Y-m-d');
//        $this->end_date = Carbon::now()->format('Y-m-d');
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {

        $this->calcTotals();

        return view('livewire.service_order-expense.service_order-expense-dashboard', [
            'expenses_total' => $this->expenses_total,
            'sales_total' => $this->sales_total,
        ]);
    }

    public function emitDates()
    {
        $this->emit('setDates', $this->start_date, $this->end_date);
    }


    public function calcTotals(){
        $this->expenses_total = Expense::select('*')
            ->whereBetween('expenses.created_at', [$this->start_date, $this->end_date])
            ->where('expenses.state', 'ACTIVE')
            ->sum('expenses.purchase');

        $this->sales_total = ServiceOrder::select('*')
            ->whereBetween('sales.created_at', [$this->start_date, $this->end_date])
            ->where('sales.state', 'ACTIVE')
            ->sum('sales.have');
        $this->utility = $this->sales_total - $this->expenses_total;
    }

    public function changeInputDate()
    {
        $this->calcTotals();
        //dd($this->expenses_total);
    }


}
